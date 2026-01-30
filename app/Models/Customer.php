<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'email',
        'phone',
        'billing_address',
        'shipping_address',
        'portal_password',
    ];

    protected $hidden = [
        'portal_password',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
