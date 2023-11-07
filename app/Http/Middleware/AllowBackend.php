<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Symfony\Component\HttpFoundation\Response;
class AllowBackend
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
        if (!Helper::isAdmin() && !Helper::isEditor()) {
            return response()->json(['status' => 'error', 'message' => 'Access Denied, You don’t have permission'], Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
        }
        return $next($request);
    }
}
