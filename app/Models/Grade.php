<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Auditable;

class Grade extends Model
{
    use Auditable, SoftDeletes;

    protected $fillable = [
        'student_id',
        'school_class_id',
        'evaluation_type',
        'score',
        'cycle',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'cycle' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope('user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->whereHas('schoolClass', function (Builder $q) {
                    $q->where('school_classes.user_id', auth()->id());
                });
            }
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
