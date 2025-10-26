<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureOrganizationAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Skip middleware for admin users
        if ($user && $user->isAdmin()) {
            return $next($request);
        }
        
        // Ensure user has an organization
        if (!$user || !$user->organization_id) {
            abort(403, 'Geen toegang tot organisatie.');
        }
        
        // Check if organization is active
        if ($user->organization && $user->organization->status !== 'active') {
            abort(403, 'Organisatie is niet actief.');
        }
        
        return $next($request);
    }
}
