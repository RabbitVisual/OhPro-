<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Modules\Core\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonPlan extends Model
{
    use Auditable, BelongsToUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'template_key',
        'sections',
        'notes',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'sections' => 'array',
            'is_public' => 'boolean',
        ];
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(LessonPlanContent::class);
    }

    public function schoolClasses(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'lesson_plan_school_class', 'lesson_plan_id', 'school_class_id')
            ->withPivot(['applied_at', 'status', 'additional_notes'])
            ->withTimestamps();
    }
}
