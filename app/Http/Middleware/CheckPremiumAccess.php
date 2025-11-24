<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPremiumAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->hasActivePremium()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Accès Premium requis',
                    'upgrade_url' => route('premium.show')
                ], 403);
            }
            return redirect()->route('premium.show')
                ->with('error', 'Cette fonctionnalité nécessite un abonnement Premium');
        }

        return $next($request);
    }
}
