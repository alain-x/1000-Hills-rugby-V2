<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCoach
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->isCoach(), 403, 'Only a coach can record attendance, rate players, or write reports.');

        return $next($request);
    }
}
