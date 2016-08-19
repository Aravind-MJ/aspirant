<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelRedirectSuperAdmin
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
        if (Sentinel::check()) {
            $user = Sentinel::getUser();
            $admin = Sentinel::findRoleByName('SuperAdmin');

            if ($user->inRole($admin)) {
                return redirect()->intended('sadmin');
            }
        }
        return $next($request);
    }
}
