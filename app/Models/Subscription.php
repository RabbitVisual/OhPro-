<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'gateway',
        'gateway_subscription_id',
        'gateway_customer_id',
        'status',
        'trial_ends_at',
        'current_period_start',
        'current_period_end',
        'canceled_at',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'trial_ends_at' => 'datetime',
            'current_period_start' => 'datetime',
            'current_period_end' => 'datetime',
            'canceled_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['trialing', 'active']);
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled');
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['trialing', 'active'], true);
    }

    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function onGracePeriod(): bool
    {
        return $this->canceled_at && $this->current_period_end && $this->current_period_end->isFuture();
    }

    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }
}
