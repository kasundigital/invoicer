<x-layouts.app>
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="text-lg font-semibold">Invoice {{ $invoice->invoice_number }}</h2>
        <p class="text-sm text-slate-600">Status: {{ ucfirst($invoice->status) }}</p>
        <div class="mt-4 flex gap-3">
            <a class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white" href="{{ route('invoices.pay', $invoice->pay_token) }}">Pay Now</a>
            <a class="rounded border border-slate-200 px-4 py-2 text-sm" href="{{ route('invoices.pdf', $invoice) }}">Download PDF</a>
        </div>
    </div>
</x-layouts.app>
