<?php

namespace App\Http\Middleware;

use Closure;

class DriverIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->approved_at) {
            return $next($request);
        }

        abort(403, 'Your account is not approved.');
    }
}
