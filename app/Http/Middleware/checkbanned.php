<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkbanned
{
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Auth::guard('web');

        if ($guard->check() && $guard->user()->is_banned) {
            $reason = $guard->user()->ban_reason ?? 'Belirtilmemiş';

            $guard->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Hesabınız banlandı. Sebep: ' . $reason]);
        }

        return $next($request);
    }
}
