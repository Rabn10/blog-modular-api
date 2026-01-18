<?php

namespace Modules\Blog\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
                'data' => []
            ], 403);
        }
        return $next($request);
    }
}
