<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isCustomer() || ! $user->is_active) {
            if ($request->expectsJson() || $request->ajax()) {
                abort(401);
            }

            return redirect()
                ->guest(route('account.login'))
                ->with('error', 'Please sign in to continue.');
        }

        return $next($request);
    }
}
