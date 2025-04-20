<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeAkun
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $tingkat = ''): Response
    {
        // return $next($request);
        $akun = $request->user();
        if ($akun->hasTingkat($tingkat)) {
            return $next($request);
        }
        abort(404, 'kamu nyasar');
    }
}
