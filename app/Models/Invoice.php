<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'organization_id',
        'customer_id',
        'invoice_number',
        'status',
        'issued_at',
        'due_at',
        'subtotal',
        'tax_total',
        'discount_total',
        'total',
        'amount_due',
        'notes',
        'terms',
        'viewed_at',
        'pay_token',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'due_at' => 'date',
        'viewed_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
