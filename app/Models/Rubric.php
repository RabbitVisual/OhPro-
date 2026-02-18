<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Auditable;

class Rubric extends Model
{
    use Auditable, BelongsToUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'school_id',
        'name',
        'description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function levels(): HasMany
    {
        return $this->hasMany(RubricLevel::class)->orderBy('sort_order');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(RubricAssessment::class);
    }
}
