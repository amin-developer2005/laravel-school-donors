<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\Response as AuthResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPanelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->hasRole('admin')) {
            return redirect()->route('filament.schoolDonors.pages.dashboard');
        }

        return $next($request);
    }
}
