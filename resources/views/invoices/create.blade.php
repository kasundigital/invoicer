<x-layouts.app>
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="text-lg font-semibold">Quick Invoice</h2>
        <p class="text-sm text-slate-500">Create an invoice fast with autocomplete-ready fields.</p>

        <form class="mt-6 grid gap-4" method="POST" action="{{ route('invoices.store') }}">
            @csrf
            <label class="block">
                <span class="text-sm font-medium">Customer</span>
                <input name="customer_id" placeholder="Search customer" class="mt-1 w-full rounded border-slate-200" />
            </label>
            <div class="grid gap-4 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-medium">Issue Date</span>
                    <input type="date" name="issued_at" class="mt-1 w-full rounded border-slate-200" />
                </label>
                <label class="block">
                    <span class="text-sm font-medium">Due Date</span>
                    <input type="date" name="due_at" class="mt-1 w-full rounded border-slate-200" />
                </label>
            </div>
            <label class="block">
                <span class="text-sm font-medium">Notes</span>
                <textarea name="notes" rows="3" class="mt-1 w-full rounded border-slate-200"></textarea>
            </label>
            <label class="block">
                <span class="text-sm font-medium">Terms</span>
                <textarea name="terms" rows="3" class="mt-1 w-full rounded border-slate-200"></textarea>
            </label>
            <div class="flex justify-end">
                <button class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Create invoice</button>
            </div>
        </form>
    </div>
</x-layouts.app>
