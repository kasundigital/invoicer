<x-layouts.app>
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="text-lg font-semibold">Invoices</h2>
            <ul class="mt-4 space-y-2 text-sm">
                @forelse($invoices as $invoice)
                    <li class="flex items-center justify-between">
                        <span>{{ $invoice->invoice_number }}</span>
                        <a class="text-indigo-600" href="{{ route('portal.invoices.show', $invoice) }}">View</a>
                    </li>
                @empty
                    <li class="text-slate-500">No invoices yet.</li>
                @endforelse
            </ul>
        </div>
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="text-lg font-semibold">Quotes</h2>
            <ul class="mt-4 space-y-2 text-sm">
                @forelse($quotes as $quote)
                    <li class="flex items-center justify-between">
                        <span>{{ $quote->quote_number }}</span>
                        <a class="text-indigo-600" href="{{ route('portal.quotes.show', $quote) }}">View</a>
                    </li>
                @empty
                    <li class="text-slate-500">No quotes yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-layouts.app>
