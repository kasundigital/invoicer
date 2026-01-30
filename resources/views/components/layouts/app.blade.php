<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Invoicer' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-full bg-slate-50 text-slate-900">
    <div class="min-h-full">
        <header class="bg-white shadow">
            <div class="mx-auto max-w-6xl px-4 py-4 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-semibold">Invoicer</h1>
                    <p class="text-sm text-slate-500">Multi-tenant invoicing workflow</p>
                </div>
                <nav class="flex flex-wrap items-center gap-4 text-sm font-medium">
                    <a class="hover:text-indigo-600" href="/invoices">Invoices</a>
                    <a class="hover:text-indigo-600" href="/branding">Branding</a>
                    <a class="hover:text-indigo-600" href="/reports/ar-aging">Reports</a>
                    <a class="hover:text-indigo-600" href="/portal">Customer Portal</a>
                    @if(session('staff_id'))
                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <button class="text-sm text-slate-500 hover:text-indigo-600">Logout</button>
                        </form>
                    @else
                        <a class="hover:text-indigo-600" href="{{ route('auth.login') }}">Staff Login</a>
                    @endif
                    @if(session('customer_id'))
                        <form method="POST" action="{{ route('portal.logout') }}">
                            @csrf
                            <button class="text-sm text-slate-500 hover:text-indigo-600">Portal Logout</button>
                        </form>
                    @else
                        <a class="hover:text-indigo-600" href="{{ route('portal.login') }}">Portal Login</a>
                    @endif
                </nav>
            </div>
        </header>
        <main class="mx-auto max-w-6xl px-4 py-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
