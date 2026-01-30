<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PortalAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('portal.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $customer = Customer::where('email', $validated['email'])->first();

        if (!$customer || !$customer->portal_password || !Hash::check($validated['password'], $customer->portal_password)) {
            return back()->withErrors(['email' => 'Invalid portal credentials.'])->withInput();
        }

        $request->session()->put('customer_id', $customer->id);

        return redirect()->route('portal.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('customer_id');

        return redirect()->route('portal.login');
    }
}
