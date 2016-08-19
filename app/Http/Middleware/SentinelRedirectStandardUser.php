<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelRedirectStandardUser
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
            $users = Sentinel::findRoleByName('Users');

            if ($user->inRole($users)) {
                return redirect()->intended('home');
            }
        }
        return $next($request);
    }
}
