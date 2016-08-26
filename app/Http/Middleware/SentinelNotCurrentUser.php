<?php

namespace App\Http\Middleware;

use App\Encrypt;
use Sentinel;
use Closure;

class SentinelNotCurrentUser
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
        $user = Sentinel::getUser();
        $routeID = $request->route()->parameters()['id'];

        if ($user->id != (int)Encrypt::decrypt($routeID)) {
            return redirect()->back();
        }

        return $next($request);
    }
}
