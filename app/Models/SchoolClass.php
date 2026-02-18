<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Modules\Core\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model
{
    use Auditable, BelongsToUser, SoftDeletes;

    protected $table = 'school_classes';

    protected $fillable = [
        'user_id',
        'school_id',
        'name',
        'code',
        'grade_level',
        'subject',
        'year',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
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

    public function lessonPlans(): BelongsToMany
    {
        return $this->belongsToMany(LessonPlan::class, 'lesson_plan_school_class', 'school_class_id', 'lesson_plan_id')
            ->withPivot(['applied_at', 'status', 'additional_notes'])
            ->withTimestamps();
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'school_class_student', 'school_class_id', 'student_id')
            ->withTimestamps();
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class, 'school_class_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'school_class_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class, 'school_class_id');
    }

    public function classDiaries(): HasMany
    {
        return $this->hasMany(ClassDiary::class, 'school_class_id');
    }
}
