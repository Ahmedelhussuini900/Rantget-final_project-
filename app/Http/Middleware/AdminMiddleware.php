<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized Access'); // ❌ منع الوصول إذا لم يكن المستخدم أدمن
        }

        return $next($request);
    }
}
