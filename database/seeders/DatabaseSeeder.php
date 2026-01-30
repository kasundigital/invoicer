<?php

namespace Database\Seeders;

use App\Models\BrandingSetting;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $organization = Organization::create([
            'name' => 'Demo Organization',
            'timezone' => 'UTC',
            'currency' => 'USD',
        ]);

        User::create([
            'organization_id' => $organization->id,
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        BrandingSetting::create([
            'organization_id' => $organization->id,
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
        ]);
    }
}
