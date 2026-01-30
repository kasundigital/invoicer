<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function dashboard(): View
    {
        $invoices = Invoice::orderByDesc('issued_at')->limit(10)->get();
        $quotes = Quote::orderByDesc('issued_at')->limit(10)->get();

        return view('portal.dashboard', [
            'invoices' => $invoices,
            'quotes' => $quotes,
        ]);
    }

    public function showInvoice(Invoice $invoice): View
    {
        return view('portal.invoice', [
            'invoice' => $invoice,
        ]);
    }

    public function showQuote(Quote $quote): View
    {
        return view('portal.quote', [
            'quote' => $quote,
        ]);
    }

    public function acceptQuote(Quote $quote): RedirectResponse
    {
        $quote->update(['status' => 'accepted']);

        return back();
    }

    public function rejectQuote(Quote $quote): RedirectResponse
    {
        $quote->update(['status' => 'rejected']);

        return back();
    }
}
