<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Modules\Core\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use Auditable, BelongsToUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'short_name',
        'color',
        'timezone',
        'logo_path',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClasses(): HasMany
    {
        return $this->hasMany(SchoolClass::class, 'school_id');
    }
}
