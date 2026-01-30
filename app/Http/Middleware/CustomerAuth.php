<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $customerId = $request->session()->get('customer_id');

        if (!$customerId || !Customer::whereKey($customerId)->exists()) {
            return redirect()->route('portal.login');
        }

        return $next($request);
    }
}
