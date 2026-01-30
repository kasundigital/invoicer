<x-layouts.app>
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="text-lg font-semibold">Pay Invoice {{ $invoice->invoice_number }}</h2>
        <p class="mt-2 text-sm text-slate-600">Amount due: {{ number_format($invoice->amount_due, 2) }}</p>
        <div class="mt-6">
            <button class="rounded bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Simulate Payment Success</button>
        </div>
    </div>
</x-layouts.app>
