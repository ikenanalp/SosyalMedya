<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class admin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->role != User::ROLE_ADMIN) {
            abort(403, 'Bu sayfaya erisim yetkiniz yok.');
        }

        return $next($request);
    }
}
