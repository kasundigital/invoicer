<x-layouts.app>
    <div class="space-y-6">
        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Invoice {{ $invoice->invoice_number }}</h2>
                    <p class="text-sm text-slate-500">Status: {{ ucfirst($invoice->status) }}</p>
                </div>
                <div class="flex gap-2">
                    <a class="rounded border border-slate-200 px-3 py-2 text-sm" href="{{ route('invoices.pdf', $invoice) }}">Download PDF</a>
                    <form method="POST" action="{{ route('invoices.send-email', $invoice) }}">
                        @csrf
                        <button class="rounded bg-indigo-600 px-3 py-2 text-sm font-semibold text-white">Send Email</button>
                    </form>
                </div>
            </div>
            @if(session('status'))
                <p class="mt-3 text-sm text-emerald-600">{{ session('status') }}</p>
            @endif
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 rounded-lg bg-white p-6 shadow">
                <h3 class="text-base font-semibold">Activity Timeline</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    @forelse($invoice->activityLogs as $log)
                        <li class="rounded border border-slate-100 p-3">
                            <div class="flex items-center justify-between">
                                <span class="font-medium">{{ ucfirst($log->action) }}</span>
                                <span class="text-xs text-slate-400">{{ $log->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <p class="mt-1 text-slate-600">{{ $log->description }}</p>
                        </li>
                    @empty
                        <li class="text-slate-500">No activity recorded yet.</li>
                    @endforelse
                </ul>
            </div>
            <div class="rounded-lg bg-white p-6 shadow">
                <h3 class="text-base font-semibold">Customer</h3>
                <p class="mt-2 text-sm text-slate-600">{{ $invoice->customer->name ?? 'Customer' }}</p>
                <p class="text-xs text-slate-400">{{ $invoice->customer->email ?? 'no email' }}</p>
                <div class="mt-4">
                    <p class="text-sm font-medium">Amount Due</p>
                    <p class="text-lg font-semibold">{{ number_format($invoice->amount_due, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
