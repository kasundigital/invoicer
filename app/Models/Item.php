<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'sku',
        'description',
        'unit_price',
        'tax_rate',
    ];
}
