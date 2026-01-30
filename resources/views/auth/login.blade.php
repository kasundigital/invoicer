<x-layouts.app>
    <div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow">
        <h2 class="text-lg font-semibold">Staff Login</h2>
        <p class="text-sm text-slate-500">Sign in to manage invoices.</p>

        <form class="mt-6 space-y-4" method="POST" action="{{ route('auth.login.submit') }}">
            @csrf
            <label class="block">
                <span class="text-sm font-medium">Email</span>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded border-slate-200" />
                @error('email')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </label>
            <label class="block">
                <span class="text-sm font-medium">Password</span>
                <input type="password" name="password" class="mt-1 w-full rounded border-slate-200" />
                @error('password')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </label>
            <button class="w-full rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Sign in</button>
        </form>
    </div>
</x-layouts.app>
