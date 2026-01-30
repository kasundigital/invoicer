<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
    protected $fillable = [
        'organization_id',
        'customer_id',
        'quote_number',
        'status',
        'issued_at',
        'expires_at',
        'subtotal',
        'tax_total',
        'discount_total',
        'total',
        'notes',
        'terms',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'expires_at' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(QuoteLine::class);
    }
}
