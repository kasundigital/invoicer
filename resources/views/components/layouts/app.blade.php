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
            <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold">Invoicer</h1>
                    <p class="text-sm text-slate-500">Multi-tenant invoicing workflow</p>
                </div>
                <nav class="flex gap-4 text-sm font-medium">
                    <a class="hover:text-indigo-600" href="/invoices">Invoices</a>
                    <a class="hover:text-indigo-600" href="/branding">Branding</a>
                    <a class="hover:text-indigo-600" href="/portal">Customer Portal</a>
                </nav>
            </div>
        </header>
        <main class="mx-auto max-w-6xl px-4 py-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
