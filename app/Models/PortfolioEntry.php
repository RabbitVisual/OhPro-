<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Auditable;

class PortfolioEntry extends Model
{
    use Auditable, SoftDeletes;

    public const TYPE_OBSERVATION = 'observation';

    public const TYPE_GRADE_CHANGE = 'grade_change';

    public const TYPE_ATTENDANCE_ALERT = 'attendance_alert';

    public const TYPE_ACHIEVEMENT = 'achievement';

    protected $fillable = [
        'student_id',
        'user_id',
        'school_class_id',
        'type',
        'title',
        'content',
        'occurred_at',
        'library_file_id',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'occurred_at' => 'datetime',
            'metadata' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope('teacher', function (Builder $builder) {
            if (auth()->check()) {
                $builder->whereHas('student', fn (Builder $q) => $q->where('students.user_id', auth()->id()));
            }
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function libraryFile(): BelongsTo
    {
        return $this->belongsTo(LibraryFile::class);
    }
}
