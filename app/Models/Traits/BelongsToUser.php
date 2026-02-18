<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToUser
{
    /**
     * Boot the trait: add global scope so all queries are scoped to the current user.
     */
    public static function bootBelongsToUser(): void
    {
        static::addGlobalScope('user', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where($builder->getModel()->getTable() . '.user_id', auth()->id());
            }
        });
    }
}
