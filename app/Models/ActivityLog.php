<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'organization_id',
        'user_id',
        'subject_type',
        'subject_id',
        'action',
        'description',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
