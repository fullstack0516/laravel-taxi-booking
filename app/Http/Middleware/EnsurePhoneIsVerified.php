<?php

namespace App\Http\Middleware;

use Closure;

class EnsurePhoneIsVerified
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
        if (! $request->user()->hasVerifiedPhone()) {
//            $user_social = $request->user()->social;
//            if ($user_social) {
//                return redirect()->route('phoneverification.send');
//            }
//            return redirect()->route('phoneverification.notice');
            return redirect()->route('phoneverification.send');
        }

        return $next($request);
    }
}
