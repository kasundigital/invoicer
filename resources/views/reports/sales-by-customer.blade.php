<x-layouts.app>
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="text-lg font-semibold">Sales by Customer</h2>
        <p class="text-sm text-slate-500">Paid invoice totals by customer.</p>

        <table class="mt-6 w-full text-sm">
            <thead class="bg-slate-100 text-left text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-2">Customer</th>
                    <th class="px-4 py-2">Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $row)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $row->customer_name }}</td>
                        <td class="px-4 py-3">{{ number_format($row->total_sales, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-center text-slate-500" colspan="2">No sales yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
