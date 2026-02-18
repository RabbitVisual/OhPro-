<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'price_monthly',
        'price_yearly',
        'interval',
        'features',
        'limits',
        'stripe_price_id',
        'stripe_price_yearly_id',
        'mercadopago_plan_id',
        'sort',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_monthly' => 'decimal:2',
            'price_yearly' => 'decimal:2',
            'features' => 'array',
            'limits' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort')->orderBy('id');
    }

    public function isFree(): bool
    {
        return $this->key === 'free';
    }

    public function isPro(): bool
    {
        return in_array($this->key, ['pro', 'pro_annual'], true);
    }

    public function getLimit(string $key): ?int
    {
        $limits = $this->limits ?? [];
        return $limits[$key] ?? null;
    }

    public function hasFeature(string $feature): bool
    {
        $features = $this->features ?? [];
        return in_array($feature, $features, true);
    }

    public function formattedPriceMonthly(): string
    {
        if ($this->price_monthly == 0) {
            return 'Grátis';
        }
        return 'R$ ' . number_format((float) $this->price_monthly, 2, ',', '.');
    }

    public function formattedPriceYearly(): ?string
    {
        if ($this->price_yearly === null || (float) $this->price_yearly == 0) {
            return null;
        }
        return 'R$ ' . number_format((float) $this->price_yearly, 2, ',', '.');
    }
}
