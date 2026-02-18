<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LessonPlanTemplate extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'structure',
        'is_system',
    ];

    protected function casts(): array
    {
        return [
            'structure' => 'array',
            'is_system' => 'boolean',
        ];
    }

    public function lessonPlans(): HasMany
    {
        return $this->hasMany(LessonPlan::class, 'template_key', 'key');
    }
}
