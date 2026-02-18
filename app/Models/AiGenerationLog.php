<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiGenerationLog extends Model
{
    public const TYPE_LESSON_PLAN = 'lesson_plan';

    protected $fillable = ['user_id', 'type'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function countThisMonth(int $userId, string $type = self::TYPE_LESSON_PLAN): int
    {
        return self::where('user_id', $userId)
            ->where('type', $type)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }
}
