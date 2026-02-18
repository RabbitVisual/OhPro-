<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Modules\Core\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use Auditable, BelongsToUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'identifier',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClasses(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'school_class_student', 'student_id', 'school_class_id')
            ->withTimestamps();
    }
}
