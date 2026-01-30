<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: {{ $branding->font_family ?? 'Inter' }}, Arial, sans-serif;
            color: #0f172a;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid {{ $branding->primary_color ?? '#2563eb' }};
            padding-bottom: 12px;
        }
        .badge {
            background: {{ $branding->secondary_color ?? '#0f172a' }};
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border-bottom: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        .totals {
            margin-top: 16px;
            text-align: right;
        }
        .footer {
            margin-top: 32px;
            font-size: 11px;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h2>Invoice {{ $invoice->invoice_number }}</h2>
            <p>Issued {{ $invoice->issued_at?->format('M d, Y') }}</p>
        </div>
        <div class="badge">{{ ucfirst($branding->pdf_theme ?? 'classic') }} Theme</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                @if($branding->show_sku)
                    <th>SKU</th>
                @endif
                <th>Qty</th>
                <th>Rate</th>
                @if($branding->show_tax)
                    <th>Tax</th>
                @endif
                @if($branding->show_discount)
                    <th>Discount</th>
                @endif
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->lines as $line)
                <tr>
                    <td>{{ $line->description }}</td>
                    @if($branding->show_sku)
                        <td>{{ $line->item->sku ?? '-' }}</td>
                    @endif
                    <td>{{ $line->quantity }}</td>
                    <td>{{ number_format($line->unit_price, 2) }}</td>
                    @if($branding->show_tax)
                        <td>{{ number_format($line->tax_rate, 2) }}%</td>
                    @endif
                    @if($branding->show_discount)
                        <td>{{ number_format($line->discount, 2) }}</td>
                    @endif
                    <td>{{ number_format($line->line_total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p>Subtotal: {{ number_format($invoice->subtotal, 2) }}</p>
        <p>Tax: {{ number_format($invoice->tax_total, 2) }}</p>
        <p>Discount: {{ number_format($invoice->discount_total, 2) }}</p>
        <h3>Total Due: {{ number_format($invoice->amount_due, 2) }}</h3>
    </div>

    @if($branding->show_notes && $invoice->notes)
        <p><strong>Notes:</strong> {{ $invoice->notes }}</p>
    @endif

    @if($branding->show_terms && $invoice->terms)
        <p><strong>Terms:</strong> {{ $invoice->terms }}</p>
    @endif

    <div class="footer">
        {{ $branding->footer_text }}
    </div>
</body>
</html>
