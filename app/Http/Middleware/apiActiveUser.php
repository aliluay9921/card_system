<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class apiActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!Auth::user()->activate_at) {
            $errors=(object)['user'=>['يوزر غير فعال']];

             return response(compact('errors'), 401);

        }
        return $next($request);
    }
}
