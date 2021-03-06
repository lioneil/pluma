<?php

namespace Course\Support\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait OnlyBookmarkedByScope
{
    /**
     * Retrieve all resources owned by given user model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \User\Models\User    $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scopeOnlyBookmarkedBy(Builder $builder, $user_id)
    {
        return $builder->whereHas('bookmarks', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        });
    }
}
