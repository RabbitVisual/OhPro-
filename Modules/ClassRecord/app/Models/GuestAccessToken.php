<?php

namespace Modules\ClassRecord\Models;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestAccessToken extends Model
{
    protected $table = 'guest_access_tokens';

    protected $fillable = [
        'student_id',
        'token',
        'expires_at',
        'created_by',
        'usage_count',
        'last_used_at',
        'reference_name',
        'active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isValid(): bool
    {
        return $this->active && $this->expires_at->isFuture();
    }
}
