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
        ]);
    }

    public function checkout(Request $request, string $plan)
    {
        $organization = $request->user()->organization;
        
        if (!in_array($plan, ['starter', 'pro'])) {
            return redirect()->route('app.subscription.index')
                ->with('error', 'Ongeldig plan geselecteerd');
        }

        $checkoutUrl = $this->subscriptionService->getCheckoutUrl($organization, $plan);
        
        return redirect()->away($checkoutUrl);
    }

    public function callback(Request $request)
    {
        // For localhost testing, activate subscription immediately on callback
        $plan = $request->query('plan', 'starter');
        $organization = $request->user()->organization;
        
        // Activate subscription directly (webhook won't work on localhost)
        if ($plan && in_array($plan, ['starter', 'pro'])) {
            $organization->update([
                'subscription_plan' => $plan,
                'subscription_status' => 'active',
                'trial_ends_at' => null,
                'subscription_ends_at' => null,
            ]);
            
            return redirect()->route('app.subscription.index')
                ->with('message', 'Betaling succesvol! Je ' . ucfirst($plan) . ' abonnement is nu actief.');
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
                
                $organization = \App\Models\Organization::find($organizationId);
                
                if ($organization) {
                    $this->subscriptionService->createSubscription($organization, $plan);
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

