<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::creating(function ($model) {
            if (Auth::check() && self::hasAuditColumn($model, 'created_by')) {
                $model->setAttribute('created_by', Auth::id());
            }
        });

        static::updating(function ($model) {
            if (Auth::check() && self::hasAuditColumn($model, 'updated_by')) {
                $model->setAttribute('updated_by', Auth::id());
            }
        });

        static::deleting(function ($model) {
            if (Auth::check() && self::hasAuditColumn($model, 'deleted_by')) {
                $model->setAttribute('deleted_by', Auth::id());
                $model->saveQuietly();
            }
        });
    }

    protected static function hasAuditColumn($model, string $column): bool
    {
        return Schema::hasColumn($model->getTable(), $column);
    }
}
