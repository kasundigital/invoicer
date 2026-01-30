<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::orderByDesc('issued_at')->paginate(15);

        return view('invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    public function create(): View
    {
        return view('invoices.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'integer'],
            'issued_at' => ['required', 'date'],
            'due_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'terms' => ['nullable', 'string', 'max:1000'],
        ]);

        $invoice = Invoice::create([
            ...$validated,
            'organization_id' => 1,
            'invoice_number' => 'INV-' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT),
            'status' => 'draft',
            'subtotal' => 0,
            'tax_total' => 0,
            'discount_total' => 0,
            'total' => 0,
            'amount_due' => 0,
            'pay_token' => Str::random(32),
        ]);

        return redirect()->route('invoices.index');
    }

    public function duplicate(Invoice $invoice): RedirectResponse
    {
        $newInvoice = $invoice->replicate();
        $newInvoice->invoice_number = 'INV-' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        $newInvoice->status = 'draft';
        $newInvoice->pay_token = Str::random(32);
        $newInvoice->save();

        return redirect()->route('invoices.index');
    }

    public function convertQuote(Quote $quote): RedirectResponse
    {
        $invoice = Invoice::create([
            'organization_id' => $quote->organization_id,
            'customer_id' => $quote->customer_id,
            'invoice_number' => 'INV-' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT),
            'status' => 'draft',
            'issued_at' => now(),
            'due_at' => now()->addDays(30),
            'subtotal' => $quote->subtotal,
            'tax_total' => $quote->tax_total,
            'discount_total' => $quote->discount_total,
            'total' => $quote->total,
            'amount_due' => $quote->total,
            'notes' => $quote->notes,
            'terms' => $quote->terms,
            'pay_token' => Str::random(32),
        ]);

        return redirect()->route('invoices.index');
    }

    public function payLink(string $token): View
    {
        $invoice = Invoice::where('pay_token', $token)->firstOrFail();

        return view('invoices.pay', [
            'invoice' => $invoice,
        ]);
    }
}
