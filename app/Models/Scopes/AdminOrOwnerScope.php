<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class AdminOrOwnerScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        /**
         * @var \App\Models\User
         */
        $user = Auth::user();

        if ($user->role === "ADMIN") {
            // allow all
            return;
        }

        $builder->where('user_id', $user->id);
    }
}
