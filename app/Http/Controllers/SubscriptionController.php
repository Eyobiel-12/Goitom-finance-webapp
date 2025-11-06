<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\SubscriptionService;
use Illuminate\Http\Request;

final class SubscriptionController extends Controller
{
    public function __construct(
        private readonly SubscriptionService $subscriptionService
    ) {}

    public function index(Request $request)
    {
        $organization = $request->user()->organization;
        
        return view('app.subscription.index', [
            'organization' => $organization,
            'plans' => SubscriptionService::getAllPlans(),
            'intervals' => SubscriptionService::getIntervals(),
            'payments' => $organization->subscriptionPayments()->orderByDesc('paid_at')->limit(12)->get(),
            'total_months_paid' => (int) $organization->subscriptionPayments()->where('status', 'paid')->sum('interval_months'),
            'current_interval' => $organization->getCurrentBillingInterval(),
        ]);
    }

    public function checkout(Request $request, string $plan)
    {
        $organization = $request->user()->organization;
        
        if (!in_array($plan, ['starter', 'pro'])) {
            return redirect()->route('app.subscription.index')
                ->with('error', 'Ongeldig plan geselecteerd');
        }

        $intervalMonths = (int) $request->query('interval', 1);
        $validIntervals = [1, 3, 6, 12];
        
        if (!in_array($intervalMonths, $validIntervals)) {
            $intervalMonths = 1;
        }

        $checkoutUrl = $this->subscriptionService->getCheckoutUrl($organization, $plan, $intervalMonths);
        
        return redirect()->away($checkoutUrl);
    }

    public function callback(Request $request)
    {
        // For localhost testing, activate subscription immediately on callback
        $plan = $request->query('plan', 'starter');
        $intervalMonths = (int) $request->query('interval', 1);
        $organization = $request->user()->organization;
        
        // Activate subscription directly (webhook won't work on localhost)
        if ($plan && in_array($plan, ['starter', 'pro'])) {
            $organization->update([
                'subscription_plan' => $plan,
                'subscription_status' => 'active',
                'trial_ends_at' => null,
                'subscription_ends_at' => null,
            ]);
            
            $intervalLabel = SubscriptionService::getIntervalLabel($intervalMonths);

            // Create a local payment record and send email
            $price = SubscriptionService::calculatePrice($plan, $intervalMonths);
            $payment = \App\Models\SubscriptionPayment::create([
                'organization_id' => $organization->id,
                'plan' => $plan,
                'interval_months' => $intervalMonths,
                'amount' => $price,
                'currency' => 'EUR',
                'gateway' => 'mollie',
                'gateway_payment_id' => 'local-callback',
                'status' => 'paid',
                'paid_at' => now(),
                'metadata' => ['source' => 'callback'],
            ]);

            try {
                if ($organization->owner?->email) {
                    \Mail::to($organization->owner->email)->send(new \App\Mail\SubscriptionPurchasedMail($payment));
                }
            } catch (\Throwable) {}
            return redirect()->route('app.subscription.index')
                ->with('message', 'Betaling succesvol! Je ' . ucfirst($plan) . ' abonnement (' . $intervalLabel . ') is nu actief.');
        }
        
        return redirect()->route('app.subscription.index')
            ->with('message', 'Betaling verwerkt! Je abonnement wordt bijgewerkt.');
    }

    public function cancel(Request $request)
    {
        $organization = $request->user()->organization;
        
        $this->subscriptionService->cancelSubscription($organization);
        
        return redirect()->route('app.subscription.index')
            ->with('message', 'Abonnement opgezegd. Je hebt nog 30 dagen toegang.');
    }

    public function webhook(Request $request)
    {
        $paymentId = $request->input('id');
        
        if (!$paymentId) {
            return response('Invalid webhook', 400);
        }

        try {
            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey(config('services.mollie.key'));
            $payment = $mollie->payments->get($paymentId);
            
            if ($payment->isPaid() && isset($payment->metadata->type) && $payment->metadata->type === 'subscription_start') {
                $organizationId = $payment->metadata->organization_id;
                $plan = $payment->metadata->plan;
                $intervalMonths = isset($payment->metadata->interval_months) ? (int) $payment->metadata->interval_months : 1;
                
                $organization = \App\Models\Organization::find($organizationId);
                
                if ($organization) {
                    $this->subscriptionService->createSubscription($organization, $plan, $intervalMonths);
                    
                    // Send email with invoice PDF
                    $latestPayment = $organization->subscriptionPayments()
                        ->where('plan', $plan)
                        ->where('interval_months', $intervalMonths)
                        ->orderByDesc('created_at')
                        ->first();
                    
                    if ($latestPayment && $organization->owner?->email) {
                        try {
                            \Mail::to($organization->owner->email)
                                ->send(new \App\Mail\SubscriptionPurchasedMail($latestPayment));
                        } catch (\Throwable $e) {
                            \Log::error('Failed to send subscription email', ['error' => $e->getMessage()]);
                        }
                    }
                }
            }
            
            return response('Webhook handled', 200);
        } catch (\Throwable $e) {
            \Log::error('Mollie webhook error', [
                'error' => $e->getMessage(),
                'payment_id' => $paymentId,
            ]);
            return response('Error', 500);
        }
    }
}

