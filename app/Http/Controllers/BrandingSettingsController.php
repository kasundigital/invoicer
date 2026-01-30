<?php

namespace App\Http\Controllers;

use App\Models\BrandingSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandingSettingsController extends Controller
{
    public function edit(Request $request): View
    {
        $organizationId = 1;
        $branding = BrandingSetting::firstOrCreate(
            ['organization_id' => $organizationId],
            [
                'primary_color' => '#2563eb',
                'secondary_color' => '#0f172a',
                'theme_mode' => 'light',
                'pdf_theme' => 'classic',
                'show_tax' => true,
                'show_discount' => true,
                'show_sku' => true,
                'show_notes' => true,
                'show_terms' => true,
                'font_family' => 'Inter',
                'footer_text' => 'Thank you for your business. Bank details: XXXX-XXXX.',
                'email_invoice_subject' => 'Invoice {{invoice_number}} from {{organization_name}}',
                'email_invoice_body' => 'Hi {{customer_name}}, please find your invoice {{invoice_number}} for {{amount_due}}. Pay here: {{pay_link}}',
                'email_reminder_upcoming_subject' => 'Upcoming invoice {{invoice_number}}',
                'email_reminder_upcoming_body' => 'Reminder: invoice {{invoice_number}} is due on {{due_date}}.',
                'email_reminder_overdue_subject' => 'Overdue invoice {{invoice_number}}',
                'email_reminder_overdue_body' => 'Your invoice {{invoice_number}} is overdue. Amount due: {{amount_due}}.',
                'number_prefix' => 'INV-',
                'number_next' => 1,
                'number_padding' => 6,
                'number_yearly_reset' => false,
            ]
        );

        return view('branding.edit', [
            'branding' => $branding,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $organizationId = 1;

        $validated = $request->validate([
            'logo' => ['nullable', 'image', 'max:2048'],
            'primary_color' => ['required', 'string', 'max:20'],
            'secondary_color' => ['required', 'string', 'max:20'],
            'theme_mode' => ['required', 'in:light,dark'],
            'pdf_theme' => ['required', 'in:classic,modern,minimal'],
            'show_tax' => ['nullable', 'boolean'],
            'show_discount' => ['nullable', 'boolean'],
            'show_sku' => ['nullable', 'boolean'],
            'show_notes' => ['nullable', 'boolean'],
            'show_terms' => ['nullable', 'boolean'],
            'font_family' => ['required', 'string', 'max:50'],
            'footer_text' => ['nullable', 'string', 'max:500'],
            'email_invoice_subject' => ['required', 'string', 'max:200'],
            'email_invoice_body' => ['required', 'string', 'max:2000'],
            'email_reminder_upcoming_subject' => ['required', 'string', 'max:200'],
            'email_reminder_upcoming_body' => ['required', 'string', 'max:2000'],
            'email_reminder_overdue_subject' => ['required', 'string', 'max:200'],
            'email_reminder_overdue_body' => ['required', 'string', 'max:2000'],
            'number_prefix' => ['required', 'string', 'max:20'],
            'number_next' => ['required', 'integer', 'min:1'],
            'number_padding' => ['required', 'integer', 'min:1', 'max:12'],
            'number_yearly_reset' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('branding', 'public');
        }

        $branding = BrandingSetting::updateOrCreate(
            ['organization_id' => $organizationId],
            [
                ...$validated,
                'show_tax' => (bool) ($validated['show_tax'] ?? false),
                'show_discount' => (bool) ($validated['show_discount'] ?? false),
                'show_sku' => (bool) ($validated['show_sku'] ?? false),
                'show_notes' => (bool) ($validated['show_notes'] ?? false),
                'show_terms' => (bool) ($validated['show_terms'] ?? false),
                'number_yearly_reset' => (bool) ($validated['number_yearly_reset'] ?? false),
            ]
        );

        return redirect()
            ->route('branding.edit')
            ->with('status', 'Branding settings updated.');
    }
}
