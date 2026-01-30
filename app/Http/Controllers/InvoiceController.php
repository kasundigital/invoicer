<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\BrandingSetting;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::with('customer')->orderByDesc('issued_at')->paginate(15);

        return view('invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load(['customer', 'lines.item', 'activityLogs']);

        return view('invoices.show', [
            'invoice' => $invoice,
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

        $this->logActivity($invoice, 'created', 'Invoice created from quick create.');

        return redirect()->route('invoices.index');
    }

    public function duplicate(Invoice $invoice): RedirectResponse
    {
        $newInvoice = $invoice->replicate();
        $newInvoice->invoice_number = 'INV-' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        $newInvoice->status = 'draft';
        $newInvoice->pay_token = Str::random(32);
        $newInvoice->save();

        $this->logActivity($newInvoice, 'duplicated', 'Invoice duplicated from ' . $invoice->invoice_number . '.');

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

        $this->logActivity($invoice, 'converted', 'Converted from quote ' . $quote->quote_number . '.');

        return redirect()->route('invoices.index');
    }

    public function payLink(string $token): View
    {
        $invoice = Invoice::where('pay_token', $token)->firstOrFail();

        if (!$invoice->viewed_at) {
            $invoice->update(['viewed_at' => now()]);
            $this->logActivity($invoice, 'viewed', 'Customer viewed invoice via payment link.');
        }

        return view('invoices.pay', [
            'invoice' => $invoice,
        ]);
    }

    public function completePayment(string $token): RedirectResponse
    {
        $invoice = Invoice::where('pay_token', $token)->firstOrFail();

        if ($invoice->amount_due <= 0) {
            return back()->with('status', 'Invoice already paid.');
        }

        Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount_due,
            'payment_date' => now(),
            'method' => 'manual',
            'notes' => 'Simulated payment from pay link.',
        ]);

        $invoice->update([
            'status' => 'paid',
            'amount_due' => 0,
        ]);

        $this->logActivity($invoice, 'paid', 'Payment completed via pay link.');

        return back()->with('status', 'Payment recorded.');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $branding = BrandingSetting::where('organization_id', $invoice->organization_id)->first();

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice->load(['lines.item', 'customer']),
            'branding' => $branding,
        ]);

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function sendEmail(Request $request, Invoice $invoice): RedirectResponse
    {
        $branding = BrandingSetting::where('organization_id', $invoice->organization_id)->first();
        $customer = $invoice->customer;

        if (!$customer || !$customer->email) {
            return back()->with('status', 'Customer email is missing.');
        }

        $subjectTemplate = $branding?->email_invoice_subject ?? 'Invoice {{invoice_number}}';
        $bodyTemplate = $branding?->email_invoice_body ?? 'Invoice {{invoice_number}} amount due {{amount_due}}.';

        $replacements = [
            '{{customer_name}}' => $customer->name,
            '{{invoice_number}}' => $invoice->invoice_number,
            '{{amount_due}}' => number_format($invoice->amount_due, 2),
            '{{pay_link}}' => route('invoices.pay', $invoice->pay_token),
            '{{organization_name}}' => 'Invoicer',
        ];

        $subject = str_replace(array_keys($replacements), array_values($replacements), $subjectTemplate);
        $body = str_replace(array_keys($replacements), array_values($replacements), $bodyTemplate);

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice->load(['lines.item', 'customer']),
            'branding' => $branding,
        ])->output();

        Mail::send('invoices.email', ['body' => $body], function ($message) use ($customer, $subject, $pdf, $invoice) {
            $message->to($customer->email)
                ->subject($subject)
                ->attachData($pdf, 'invoice-' . $invoice->invoice_number . '.pdf');
        });

        $this->logActivity($invoice, 'sent', 'Invoice email sent to ' . $customer->email . '.');

        return back()->with('status', 'Invoice email sent.');
    }

    protected function logActivity(Invoice $invoice, string $action, string $description): void
    {
        ActivityLog::create([
            'organization_id' => $invoice->organization_id,
            'user_id' => null,
            'subject_type' => Invoice::class,
            'subject_id' => $invoice->id,
            'action' => $action,
            'description' => $description,
        ]);
    }
}
