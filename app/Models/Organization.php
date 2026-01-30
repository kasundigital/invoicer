<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'timezone',
        'currency',
    ];

    public function brandingSettings(): HasMany
    {
        return $this->hasMany(BrandingSetting::class);
    }
}
