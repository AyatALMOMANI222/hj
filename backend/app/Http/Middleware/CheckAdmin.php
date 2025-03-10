<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // تحقق مما إذا كان المستخدم مسجلاً دخولًا وكان دوره "admin"
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized. You do not have admin privileges.'
        ], Response::HTTP_UNAUTHORIZED);
    }
}

