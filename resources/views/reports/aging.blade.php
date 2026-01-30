<x-layouts.app>
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="text-lg font-semibold">Accounts Receivable Aging</h2>
        <p class="text-sm text-slate-500">Outstanding balances grouped by due date.</p>

        <div class="mt-6 grid gap-4 md:grid-cols-5 text-sm">
            <div class="rounded border border-slate-100 p-4">
                <p class="text-xs text-slate-500">Current</p>
                <p class="text-lg font-semibold">{{ number_format($aging->current ?? 0, 2) }}</p>
            </div>
            <div class="rounded border border-slate-100 p-4">
                <p class="text-xs text-slate-500">1-30 Days</p>
                <p class="text-lg font-semibold">{{ number_format($aging->days_1_30 ?? 0, 2) }}</p>
            </div>
            <div class="rounded border border-slate-100 p-4">
                <p class="text-xs text-slate-500">31-60 Days</p>
                <p class="text-lg font-semibold">{{ number_format($aging->days_31_60 ?? 0, 2) }}</p>
            </div>
            <div class="rounded border border-slate-100 p-4">
                <p class="text-xs text-slate-500">61-90 Days</p>
                <p class="text-lg font-semibold">{{ number_format($aging->days_61_90 ?? 0, 2) }}</p>
            </div>
            <div class="rounded border border-slate-100 p-4">
                <p class="text-xs text-slate-500">90+ Days</p>
                <p class="text-lg font-semibold">{{ number_format($aging->days_90_plus ?? 0, 2) }}</p>
            </div>
        </div>
    </div>
</x-layouts.app>
