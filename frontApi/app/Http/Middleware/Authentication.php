<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Authentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = session()->get('token');
        $response = Http::withToken($token)->get('http://localhost/api/auth/me');
        $user = $response->json();
        if (empty($user)) {
            return redirect()->route('login');
        }
        // else if ($user['type'] == 'user')
        // {
        //     return redirect()->route('welcome');
        // }
        return $next($request);
    }
}
