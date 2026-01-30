<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function dashboard(Request $request): View
    {
        $customerId = $request->session()->get('customer_id');

        $invoices = Invoice::where('customer_id', $customerId)
            ->orderByDesc('issued_at')
            ->limit(10)
            ->get();

        $quotes = Quote::where('customer_id', $customerId)
            ->orderByDesc('issued_at')
            ->limit(10)
            ->get();

        return view('portal.dashboard', [
            'invoices' => $invoices,
            'quotes' => $quotes,
        ]);
    }

    public function showInvoice(Request $request, Invoice $invoice): View
    {
        $customerId = $request->session()->get('customer_id');

        abort_unless($invoice->customer_id === $customerId, 403);

        return view('portal.invoice', [
            'invoice' => $invoice,
        ]);
    }

    public function showQuote(Request $request, Quote $quote): View
    {
        $customerId = $request->session()->get('customer_id');

        abort_unless($quote->customer_id === $customerId, 403);

        return view('portal.quote', [
            'quote' => $quote,
        ]);
    }

    public function acceptQuote(Request $request, Quote $quote): RedirectResponse
    {
        $customerId = $request->session()->get('customer_id');

        abort_unless($quote->customer_id === $customerId, 403);

        $quote->update(['status' => 'accepted']);

        return back();
    }

    public function rejectQuote(Request $request, Quote $quote): RedirectResponse
    {
        $customerId = $request->session()->get('customer_id');

        abort_unless($quote->customer_id === $customerId, 403);

        $quote->update(['status' => 'rejected']);

        return back();
    }
}
