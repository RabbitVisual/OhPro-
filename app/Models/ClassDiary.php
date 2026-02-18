<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Auditable;

class ClassDiary extends Model
{
    use Auditable, SoftDeletes;

    protected $fillable = [
        'school_class_id',
        'user_id',
        'lesson_plan_id',
        'scheduled_at',
        'started_at',
        'ended_at',
        'content',
        'signature_path',
        'is_finalized',
        'signed_at',
    ];

    protected $appends = ['status'];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_finalized' => 'boolean',
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'signed_at' => 'datetime',
        ];
    }

    /**
     * Status for class log: draft until signed and finalized.
     */
    public function getStatusAttribute(): string
    {
        return $this->is_finalized ? 'finalized' : 'draft';
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lessonPlan(): BelongsTo
    {
        return $this->belongsTo(LessonPlan::class);
    }
}
