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
                $user = auth()->user();
                $model = $builder->getModel();

                $builder->where(function ($query) use ($user, $model) {
                    // Start with the basic ownership check
                    $query->where($model->getTable() . '.user_id', $user->id);

                    // Allow model to extend the OR condition (e.g., shared access)
                    if (method_exists($model, 'extendBelongsToUserScope')) {
                        $model->extendBelongsToUserScope($query, $user);
                    }
                });
            }
        });
    }
}
