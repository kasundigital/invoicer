<x-layouts.app>
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="text-lg font-semibold">Pay Invoice {{ $invoice->invoice_number }}</h2>
        <p class="mt-2 text-sm text-slate-600">Amount due: {{ number_format($invoice->amount_due, 2) }}</p>
        @if(session('status'))
            <p class="mt-2 text-sm text-emerald-600">{{ session('status') }}</p>
        @endif
        <div class="mt-6">
            <form method="POST" action="{{ route('invoices.pay.complete', $invoice->pay_token) }}">
                @csrf
                <button class="rounded bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Simulate Payment Success</button>
            </form>
        </div>
    </div>
</x-layouts.app>
