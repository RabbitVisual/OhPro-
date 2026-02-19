<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'cpf',
        'birth_date',
        'phone',
        'photo',
        'logo_path',
        'signature_path',
        'membership',
        'status',
        'password',
        'last_login_at',
        'last_login_ip',
        'current_school_id',
        'hourly_rate',
        'notification_preferences',
        'pdf_theme',
        'referral_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'last_login_at' => 'datetime',
            'hourly_rate' => 'decimal:2',
            'notification_preferences' => 'array',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's photo URL.
     */
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('assets/images/default-avatar.png');
    }

    public function schools(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(School::class);
    }

    public function schoolClasses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function currentSchool(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(School::class, 'current_school_id');
    }

    /** Schools this user manages (manager role). */
    public function managedSchools(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(School::class, 'school_managers', 'user_id', 'school_id')->withTimestamps();
    }

    public function lessonPlans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LessonPlan::class);
    }

    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /** Active subscription (trialing or active). */
    public function subscription(): ?Subscription
    {
        return $this->subscriptions()->active()->latest()->first();
    }

    /** Current effective plan (from active subscription or free). */
    public function plan(): Plan
    {
        $sub = $this->subscription();
        if ($sub && $sub->plan) {
            return $sub->plan;
        }
        return Plan::where('key', 'free')->firstOrFail();
    }

    public function isFree(): bool
    {
        return $this->membership === 'free' || ! $this->subscription()?->isActive();
    }

    public function isPro(): bool
    {
        return in_array($this->membership, ['pro', 'pro_annual'], true) && $this->subscription()?->isActive();
    }

    /** Check plan limit (e.g. max_classes). Returns true if under limit or unlimited. */
    public function withinLimit(string $limitKey, int $currentCount): bool
    {
        $plan = $this->plan();
        $max = $plan->getLimit($limitKey);
        if ($max === null) {
            return true; // unlimited
        }
        return $currentCount < $max;
    }

    public function hasFeature(string $feature): bool
    {
        return $this->plan()->hasFeature($feature);
    }

    public function referrals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Referral::class, 'referrer_id');
    }

    public function getReferralLinkAttribute(): string
    {
        if (!$this->referral_code) {
            // Generate on the fly if missing (lazy generation)
            app(\App\Services\ReferralService::class)->generateCode($this);
            $this->refresh();
        }
        return route('register', ['ref' => $this->referral_code]);
    }
}
