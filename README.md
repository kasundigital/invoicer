# Invoicer (Laravel 10)

Production-ready invoicing web app designed for Namecheap cPanel shared hosting.

## Features (MVP)
- Multi-tenant Organizations (org_id on all core tables)
- Users + RBAC (Owner/Admin/Staff/ReadOnly via role column)
- Customers, Items/Services
- Quotes + statuses + convert to invoice
- Invoices + invoice lines + viewed tracking
- Payments + partial payments
- Payment links (`/pay/{token}`) with simulated success
- Recurring invoices + reminders (artisan commands)
- Reports scaffolding (AR aging, sales by customer)
- Audit logs + activity log tables
- Branding & Templates module (logo, brand colors, PDF themes, layout toggles, email templates, numbering settings)
- Customer portal login (customers can view invoices/quotes, accept/reject quotes, download PDF)

## PDF Generation
This project uses `barryvdh/laravel-dompdf`, which works on shared hosting. PDF templates live in `resources/views/invoices/pdf.blade.php` and respect branding settings.

## Email Options
Configure `MAIL_*` in `.env` depending on your shared hosting support:
- **SMTP** (most cPanel installs): use your domain mail server.
- **Sendmail**: if enabled by the host.
- **Mailgun/SES/Postmark**: supported via Laravel mailer drivers if your host allows outbound HTTPS.

The invoice email is sent via `POST /invoices/{invoice}/send-email` and attaches the PDF.

## cPanel Deployment (Step-by-step)
1. **Create MySQL DB** in cPanel and note the DB name, user, and password.
2. **Upload code** to your domain root (e.g., `public_html/invoicer`).
3. **Set document root** to the `public/` directory (via cPanel Domains) so the app serves from `public/index.php`.
4. **Install dependencies** via SSH (or cPanel Terminal):
   ```bash
   cd ~/public_html/invoicer
   composer install --no-dev --optimize-autoloader
   ```
5. **Environment file**:
   - Copy `.env.example` to `.env` and set `APP_URL`, `DB_*`, and `APP_KEY`.
   - Generate key: `php artisan key:generate`.
6. **Storage symlink**:
   ```bash
   php artisan storage:link
   ```
7. **Run migrations + seed**:
   ```bash
   php artisan migrate --seed
   ```
8. **Set permissions** (cPanel file manager):
   - `storage/` and `bootstrap/cache/` should be writable by PHP.

## Cron Jobs (cPanel)
Add these in **cPanel → Cron Jobs** (adjust PHP path as needed):
- `php /home/USERNAME/public_html/invoicer/artisan invoicer:run-recurring`
- `php /home/USERNAME/public_html/invoicer/artisan invoicer:send-reminders`

Suggested schedule: every hour for recurring invoices and every day for reminders.

## Demo Credentials
- **Staff Login** (`/login`): `owner@example.com` / `password`
- **Customer Portal** (`/portal/login`): `customer@example.com` / `customer123`

## Development Notes
- Uploads are stored in `storage/app/public` and exposed via `storage:link`.
- Branding settings are stored per organization in `branding_settings`.
- Email templates support variables like `{{customer_name}}`, `{{invoice_number}}`, `{{amount_due}}`, `{{pay_link}}`.

## Next Steps
- Wire full auth for staff users and RBAC policies.
- Expand reports with date filters and export to CSV.
- Add online payment gateway integration.
