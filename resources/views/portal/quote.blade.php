<x-layouts.app>
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="text-lg font-semibold">Quote {{ $quote->quote_number }}</h2>
        <p class="text-sm text-slate-600">Status: {{ ucfirst($quote->status) }}</p>
        <div class="mt-4 flex gap-3">
            <form method="POST" action="{{ route('portal.quotes.accept', $quote) }}">
                @csrf
                <button class="rounded bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Accept</button>
            </form>
            <form method="POST" action="{{ route('portal.quotes.reject', $quote) }}">
                @csrf
                <button class="rounded border border-slate-200 px-4 py-2 text-sm">Reject</button>
            </form>
        </div>
    </div>
</x-layouts.app>
