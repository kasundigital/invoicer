<x-layouts.app>
    <div class="space-y-6">
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="text-lg font-semibold">Branding & Templates</h2>
            <p class="text-sm text-slate-500">Customize logo, colors, PDF themes, email templates, and numbering.</p>
        </div>

        @if(session('status'))
            <div class="rounded-md bg-emerald-50 p-4 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <form class="space-y-6" method="POST" enctype="multipart/form-data" action="{{ route('branding.update') }}">
            @csrf
            <div class="rounded-lg bg-white p-6 shadow">
                <h3 class="text-base font-semibold">Organization Branding</h3>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-medium">Company Logo</span>
                        <input type="file" name="logo" class="mt-1 block w-full text-sm" />
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Primary Color</span>
                        <input type="text" name="primary_color" value="{{ old('primary_color', $branding->primary_color) }}" class="mt-1 w-full rounded border-slate-200" />
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Secondary Color</span>
                        <input type="text" name="secondary_color" value="{{ old('secondary_color', $branding->secondary_color) }}" class="mt-1 w-full rounded border-slate-200" />
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Theme Mode</span>
                        <select name="theme_mode" class="mt-1 w-full rounded border-slate-200">
                            <option value="light" @selected($branding->theme_mode === 'light')>Light</option>
                            <option value="dark" @selected($branding->theme_mode === 'dark')>Dark</option>
                        </select>
                    </label>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow">
                <h3 class="text-base font-semibold">Invoice PDF Themes</h3>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-medium">PDF Theme</span>
                        <select name="pdf_theme" class="mt-1 w-full rounded border-slate-200">
                            <option value="classic" @selected($branding->pdf_theme === 'classic')>Classic</option>
                            <option value="modern" @selected($branding->pdf_theme === 'modern')>Modern</option>
                            <option value="minimal" @selected($branding->pdf_theme === 'minimal')>Minimal</option>
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Font Family</span>
                        <select name="font_family" class="mt-1 w-full rounded border-slate-200">
                            @foreach(['Inter', 'Roboto', 'Georgia'] as $font)
                                <option value="{{ $font }}" @selected($branding->font_family === $font)>{{ $font }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="show_tax" value="1" @checked($branding->show_tax)>
                        Show tax column
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="show_discount" value="1" @checked($branding->show_discount)>
                        Show discount column
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="show_sku" value="1" @checked($branding->show_sku)>
                        Show SKU
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="show_notes" value="1" @checked($branding->show_notes)>
                        Show notes
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="show_terms" value="1" @checked($branding->show_terms)>
                        Show terms
                    </label>
                </div>
                <label class="mt-4 block">
                    <span class="text-sm font-medium">Footer Text</span>
                    <textarea name="footer_text" rows="3" class="mt-1 w-full rounded border-slate-200">{{ old('footer_text', $branding->footer_text) }}</textarea>
                </label>
            </div>

            <div class="rounded-lg bg-white p-6 shadow">
                <h3 class="text-base font-semibold">Email Templates</h3>
                <p class="text-xs text-slate-500">Use variables like {{ '{{customer_name}}' }}, {{ '{{invoice_number}}' }}, {{ '{{amount_due}}' }}, {{ '{{pay_link}}' }}.</p>
                <div class="mt-4 space-y-4">
                    <div>
                        <label class="text-sm font-medium">Invoice Subject</label>
                        <input type="text" name="email_invoice_subject" value="{{ old('email_invoice_subject', $branding->email_invoice_subject) }}" class="mt-1 w-full rounded border-slate-200" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Invoice Body</label>
                        <textarea name="email_invoice_body" rows="4" class="mt-1 w-full rounded border-slate-200">{{ old('email_invoice_body', $branding->email_invoice_body) }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-medium">Upcoming Reminder Subject</label>
                        <input type="text" name="email_reminder_upcoming_subject" value="{{ old('email_reminder_upcoming_subject', $branding->email_reminder_upcoming_subject) }}" class="mt-1 w-full rounded border-slate-200" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Upcoming Reminder Body</label>
                        <textarea name="email_reminder_upcoming_body" rows="3" class="mt-1 w-full rounded border-slate-200">{{ old('email_reminder_upcoming_body', $branding->email_reminder_upcoming_body) }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-medium">Overdue Reminder Subject</label>
                        <input type="text" name="email_reminder_overdue_subject" value="{{ old('email_reminder_overdue_subject', $branding->email_reminder_overdue_subject) }}" class="mt-1 w-full rounded border-slate-200" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Overdue Reminder Body</label>
                        <textarea name="email_reminder_overdue_body" rows="3" class="mt-1 w-full rounded border-slate-200">{{ old('email_reminder_overdue_body', $branding->email_reminder_overdue_body) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="rounded-lg bg-white p-6 shadow">
                <h3 class="text-base font-semibold">Numbering Settings</h3>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <label class="block">
                        <span class="text-sm font-medium">Prefix</span>
                        <input type="text" name="number_prefix" value="{{ old('number_prefix', $branding->number_prefix) }}" class="mt-1 w-full rounded border-slate-200" />
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Next Number</span>
                        <input type="number" min="1" name="number_next" value="{{ old('number_next', $branding->number_next) }}" class="mt-1 w-full rounded border-slate-200" />
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Padding</span>
                        <input type="number" min="1" max="12" name="number_padding" value="{{ old('number_padding', $branding->number_padding) }}" class="mt-1 w-full rounded border-slate-200" />
                    </label>
                </div>
                <label class="mt-4 flex items-center gap-2 text-sm">
                    <input type="checkbox" name="number_yearly_reset" value="1" @checked($branding->number_yearly_reset)>
                    Reset numbering yearly
                </label>
            </div>

            <div class="flex justify-end">
                <button class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Save settings</button>
            </div>
        </form>
    </div>
</x-layouts.app>
