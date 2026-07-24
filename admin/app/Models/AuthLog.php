<?php

namespace App\Models;

use App\Enums\AuthLogEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthLog extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'event',
        'email_attempted',
        'ip_address',
        'user_agent_raw',
        'browser',
        'platform',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'event' => AuthLogEvent::class,
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    // ─── Relations ────────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
