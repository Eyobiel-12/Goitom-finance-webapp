<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user || !$user->organization) {
            return redirect()->route('login');
        }

        $organization = $user->organization;

        // Always allow subscription pages themselves
        if ($request->routeIs('app.subscription.*') || $request->routeIs('mollie.webhook')) {
            return $next($request);
        }

        // Active or on trial → full access
        if ($organization->hasActiveSubscription()) {
            return $next($request);
        }

        // Suspended → block completely
        if ($organization->isSuspended()) {
            return redirect()->route('app.subscription.index')
                ->with('error', 'Je account is gepauzeerd. Rond de betaling af om door te gaan.');
        }

        // Past due (grace period) → read-only (allow safe HTTP verbs)
        if ($organization->isPastDue()) {
            if (in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'])) {
                return $next($request);
            }

            return redirect()->route('app.subscription.index')
                ->with('error', 'Je trial is verlopen. Betaal om weer acties uit te voeren.');
        }

        // Fallback
        return redirect()->route('app.subscription.index')
            ->with('error', 'Je abonnement is verlopen. Upgrade om verder te gaan.');
    }
}

