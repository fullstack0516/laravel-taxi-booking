<?php

namespace App\Http\Middleware;

use Closure;

class SettingsCompleted
{

    public function handle($request, Closure $next)
    {
        if (!$request->user()->settings_completed_at) {
            return redirect()->route('settings');
        }
        return $next($request);
    }
}
