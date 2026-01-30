<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandingSetting extends Model
{
    protected $fillable = [
        'organization_id',
        'logo_path',
        'primary_color',
        'secondary_color',
        'theme_mode',
        'pdf_theme',
        'show_tax',
        'show_discount',
        'show_sku',
        'show_notes',
        'show_terms',
        'font_family',
        'footer_text',
        'email_invoice_subject',
        'email_invoice_body',
        'email_reminder_upcoming_subject',
        'email_reminder_upcoming_body',
        'email_reminder_overdue_subject',
        'email_reminder_overdue_body',
        'number_prefix',
        'number_next',
        'number_padding',
        'number_yearly_reset',
    ];

    protected $casts = [
        'show_tax' => 'boolean',
        'show_discount' => 'boolean',
        'show_sku' => 'boolean',
        'show_notes' => 'boolean',
        'show_terms' => 'boolean',
        'number_yearly_reset' => 'boolean',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
