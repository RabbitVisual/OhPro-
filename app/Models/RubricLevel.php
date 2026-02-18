<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Auditable;

class RubricLevel extends Model
{
    use Auditable, SoftDeletes;

    protected $fillable = [
        'rubric_id',
        'name',
        'description',
        'sort_order',
        'points',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'points' => 'decimal:2',
        ];
    }

    public function rubric(): BelongsTo
    {
        return $this->belongsTo(Rubric::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(RubricAssessment::class, 'rubric_level_id');
    }
}
