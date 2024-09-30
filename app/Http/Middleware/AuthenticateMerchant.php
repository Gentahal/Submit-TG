<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AuthenticateMerchant extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('merchant.login');
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, ['merchant']);
        return $next($request);
    }
}