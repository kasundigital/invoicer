<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold">Invoices</h2>
                <p class="text-sm text-slate-500">Search, filter, and manage invoices.</p>
            </div>
            <a href="{{ route('invoices.create') }}" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Quick Invoice</a>
        </div>

        <div class="rounded-lg bg-white p-4 shadow">
            <div class="grid gap-4 md:grid-cols-4">
                <input type="text" placeholder="Search invoice or customer" class="rounded border-slate-200" />
                <select class="rounded border-slate-200">
                    <option>Status</option>
                    <option>Draft</option>
                    <option>Sent</option>
                    <option>Paid</option>
                    <option>Overdue</option>
                </select>
                <input type="date" class="rounded border-slate-200" />
                <input type="date" class="rounded border-slate-200" />
            </div>
        </div>

        <div class="rounded-lg bg-white shadow">
            <table class="w-full text-sm">
                <thead class="bg-slate-100 text-left text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Invoice</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Amount Due</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr class="border-t">
                            <td class="px-4 py-3 font-medium">{{ $invoice->invoice_number }}</td>
                            <td class="px-4 py-3">{{ $invoice->customer->name ?? 'Customer' }}</td>
                            <td class="px-4 py-3">{{ ucfirst($invoice->status) }}</td>
                            <td class="px-4 py-3">{{ number_format($invoice->amount_due, 2) }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('invoices.duplicate', $invoice) }}">
                                        @csrf
                                        <button class="text-indigo-600">Duplicate</button>
                                    </form>
                                    <a class="text-indigo-600" href="{{ route('invoices.pay', $invoice->pay_token) }}">Pay Link</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-slate-500" colspan="5">No invoices yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
