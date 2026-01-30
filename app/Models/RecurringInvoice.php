<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringInvoice extends Model
{
    protected $fillable = [
        'organization_id',
        'customer_id',
        'template_invoice_id',
        'frequency',
        'next_run_at',
        'end_at',
        'is_active',
    ];

    protected $casts = [
        'next_run_at' => 'datetime',
        'end_at' => 'date',
        'is_active' => 'boolean',
    ];
}
