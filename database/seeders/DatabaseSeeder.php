<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\BrandingSetting;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Organization;
use App\Models\Quote;
use App\Models\QuoteLine;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        $customer = Customer::create([
            'organization_id' => $organization->id,
            'name' => 'Acme Corp',
            'email' => 'customer@example.com',
            'phone' => '+1 (555) 123-4567',
            'billing_address' => '100 Main Street, Springfield',
            'shipping_address' => '100 Main Street, Springfield',
            'portal_password' => Hash::make('customer123'),
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

        $invoice = Invoice::create([
            'organization_id' => $organization->id,
            'customer_id' => $customer->id,
            'invoice_number' => 'INV-000001',
            'status' => 'sent',
            'issued_at' => now()->subDays(5),
            'due_at' => now()->addDays(25),
            'subtotal' => 1200,
            'tax_total' => 96,
            'discount_total' => 0,
            'total' => 1296,
            'amount_due' => 1296,
            'notes' => 'Thank you for partnering with us.',
            'terms' => 'Net 30',
            'pay_token' => Str::random(32),
        ]);

        InvoiceLine::create([
            'invoice_id' => $invoice->id,
            'description' => 'Design and development services',
            'quantity' => 1,
            'unit_price' => 1200,
            'tax_rate' => 8,
            'discount' => 0,
            'line_total' => 1296,
        ]);

        ActivityLog::create([
            'organization_id' => $organization->id,
            'subject_type' => Invoice::class,
            'subject_id' => $invoice->id,
            'action' => 'created',
            'description' => 'Invoice created for Acme Corp.',
        ]);

        ActivityLog::create([
            'organization_id' => $organization->id,
            'subject_type' => Invoice::class,
            'subject_id' => $invoice->id,
            'action' => 'sent',
            'description' => 'Invoice emailed to customer@example.com.',
        ]);

        $quote = Quote::create([
            'organization_id' => $organization->id,
            'customer_id' => $customer->id,
            'quote_number' => 'Q-0001',
            'status' => 'sent',
            'issued_at' => now()->subDays(2),
            'expires_at' => now()->addDays(15),
            'subtotal' => 800,
            'tax_total' => 64,
            'discount_total' => 0,
            'total' => 864,
            'notes' => 'Quote valid for 15 days.',
            'terms' => 'Net 15',
        ]);

        QuoteLine::create([
            'quote_id' => $quote->id,
            'description' => 'Consulting package',
            'quantity' => 1,
            'unit_price' => 800,
            'tax_rate' => 8,
            'discount' => 0,
            'line_total' => 864,
        ]);
    }
}
