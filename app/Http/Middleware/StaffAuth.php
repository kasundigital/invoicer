<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->session()->get('staff_id');

        if (!$userId || !User::whereKey($userId)->exists()) {
            return redirect()->route('auth.login');
        }

        return $next($request);
    }
}
