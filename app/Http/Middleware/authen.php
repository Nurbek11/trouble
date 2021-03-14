<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class authen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('token');
        $user = User::where('access_token',$token)->first();
        if (!$token){
            return response()->json('not authenticated',404);
        }
        $request['user'] = $user;
        return $next($request);
    }
}
