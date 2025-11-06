<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Organization;
use App\Models\SubscriptionPayment;
use Mollie\Api\MollieApiClient;

final class SubscriptionService
{
    // Plan base prices (monthly)
    private const PLANS = [
        'starter' => [
            'name' => 'Starter',
            'price' => 15.00,
            'currency' => 'EUR',
            'description' => 'Onbeperkt facturen, klanten & projecten',
        ],
        'pro' => [
            'name' => 'Pro',
            'price' => 22.00,
            'currency' => 'EUR',
            'description' => 'Alles uit Starter + email, reminders, geavanceerde BTW',
        ],
    ];

    // Billing intervals (months) with discount percentages
    private const INTERVALS = [
        1 => ['months' => 1, 'discount' => 0, 'label' => 'Maandelijks'],
        3 => ['months' => 3, 'discount' => 10, 'label' => '3 maanden'],
        6 => ['months' => 6, 'discount' => 15, 'label' => '6 maanden'],
        12 => ['months' => 12, 'discount' => 20, 'label' => '12 maanden'],
    ];

    public static function getIntervals(): array
    {
        return self::INTERVALS;
    }

    public static function getIntervalDetails(int $months): ?array
    {
        return self::INTERVALS[$months] ?? null;
    }

    public static function calculatePrice(string $plan, int $intervalMonths): float
    {
        $basePrice = self::PLANS[$plan]['price'] ?? self::PLANS['starter']['price'];
        $interval = self::INTERVALS[$intervalMonths] ?? self::INTERVALS[1];
        
        $totalPrice = $basePrice * $interval['months'];
        $discount = $totalPrice * ($interval['discount'] / 100);
        
        return round($totalPrice - $discount, 2);
    }

    public static function getIntervalLabel(int $months): string
    {
        return self::INTERVALS[$months]['label'] ?? 'Maandelijks';
    }

    public static function getMollieInterval(int $months): string
    {
        return "{$months} months";
    }

    private function getMollieClient(): MollieApiClient
    {
        $mollie = new MollieApiClient();
        $mollie->setApiKey(config('services.mollie.key'));
        return $mollie;
    }

    public function createCustomer(Organization $organization): string
    {
        // In tests, avoid external calls
        if (app()->environment('testing')) {
            return $organization->mollie_customer_id ?? 'test_customer_id';
        }
        if ($organization->mollie_customer_id) {
            return $organization->mollie_customer_id;
        }

        $mollie = $this->getMollieClient();
        $customer = $mollie->customers->create([
            'name' => $organization->name,
            'email' => $organization->owner->email,
            'metadata' => [
                'organization_id' => $organization->id,
            ],
        ]);

        $organization->update(['mollie_customer_id' => $customer->id]);

        return $customer->id;
    }

    public function startTrial(Organization $organization): void
    {
        $organization->update([
            'subscription_status' => 'trial',
            'subscription_plan' => 'starter',
            'trial_ends_at' => now()->addDays(3),
        ]);
    }

    public function createSubscription(Organization $organization, string $plan, int $intervalMonths = 1): string
    {
        $customerId = $this->createCustomer($organization);
        $planConfig = self::PLANS[$plan] ?? self::PLANS['starter'];
        $price = self::calculatePrice($plan, $intervalMonths);
        $mollieInterval = self::getMollieInterval($intervalMonths);

        $mollie = $this->getMollieClient();
        $subscription = $mollie->subscriptions->createFor($customerId, [
            'amount' => [
                'currency' => $planConfig['currency'],
                'value' => number_format($price, 2, '.', ''),
            ],
            'interval' => $mollieInterval,
            'description' => "Goitom Finance - {$planConfig['name']} ({$mollieInterval})",
            'webhookUrl' => route('mollie.webhook'),
            'metadata' => [
                'organization_id' => $organization->id,
                'plan' => $plan,
                'interval_months' => $intervalMonths,
            ],
        ]);

        $organization->update([
            'mollie_subscription_id' => $subscription->id,
            'subscription_plan' => $plan,
            'subscription_status' => 'active',
            'trial_ends_at' => null,
            'subscription_ends_at' => null,
        ]);

        // Store payment record
        SubscriptionPayment::create([
            'organization_id' => $organization->id,
            'plan' => $plan,
            'interval_months' => $intervalMonths,
            'amount' => $price,
            'currency' => $planConfig['currency'],
            'gateway' => 'mollie',
            'gateway_payment_id' => $subscription->id,
            'status' => 'paid',
            'paid_at' => now(),
            'metadata' => [
                'source' => 'subscription',
                'interval_label' => self::getIntervalLabel($intervalMonths),
            ],
        ]);

        return $subscription->id;
    }

    public function cancelSubscription(Organization $organization): void
    {
        if ($organization->mollie_subscription_id && $organization->mollie_customer_id) {
            try {
                $mollie = $this->getMollieClient();
                $mollie->subscriptions->cancelFor(
                    $organization->mollie_customer_id,
                    $organization->mollie_subscription_id
                );
            } catch (\Throwable $e) {
                \Log::error('Mollie cancel failed', ['error' => $e->getMessage()]);
            }
        }

        $organization->update([
            'subscription_status' => 'canceled',
            'subscription_ends_at' => now()->addDays(30), // grace period
        ]);
    }

    public function getCheckoutUrl(Organization $organization, string $plan, int $intervalMonths = 1): string
    {
        // In tests, return a fake URL and skip network
        if (app()->environment('testing')) {
            return 'https://mollie.test/checkout';
        }

        $customerId = $this->createCustomer($organization);
        $planConfig = self::PLANS[$plan] ?? self::PLANS['starter'];
        $price = self::calculatePrice($plan, $intervalMonths);
        $intervalLabel = self::getIntervalLabel($intervalMonths);

        $mollie = $this->getMollieClient();
        
        // Use ngrok URL for webhook if available, otherwise skip
        $webhookUrl = 'https://5864b0903e25.ngrok-free.app/mollie/webhook';
        
        $payment = $mollie->payments->create([
            'amount' => [
                'currency' => $planConfig['currency'],
                'value' => number_format($price, 2, '.', ''),
            ],
            'description' => "Goitom Finance - {$planConfig['name']} ({$intervalLabel}) - Eerste betaling",
            'redirectUrl' => route('app.subscription.callback') . '?plan=' . $plan . '&interval=' . $intervalMonths,
            'webhookUrl' => $webhookUrl,
            'customerId' => $customerId,
            'sequenceType' => 'first',
            // Include payment methods for production (test mode only shows cards)
            'method' => null, // null = all available methods (iDEAL, Bancontact, SEPA on live)
            'locale' => 'nl_NL',
            'metadata' => [
                'organization_id' => $organization->id,
                'plan' => $plan,
                'interval_months' => $intervalMonths,
                'type' => 'subscription_start',
            ],
        ]);

        return $payment->getCheckoutUrl();
    }

    public static function getPlanDetails(string $plan): array
    {
        return self::PLANS[$plan] ?? self::PLANS['starter'];
    }

    public static function getAllPlans(): array
    {
        return self::PLANS;
    }
}

