<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Snapshot extends Pivot
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'filename',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    /**
     * Get the user for the snapshot.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
