<?php

namespace User\Scopes;

trait Avatar
{
    /**
     * Array of avatars.
     *
     * @var array
     */
    protected $avatars;

    /**
     * Exclude the given from the resource.
     *
     * @param  \Illuminate\Database\Query\Builder $builder
     * @param  mixed $ommitables
     * @param  string $column
     * @return $builder
     */
    public function scopeAvatars()
    {
        $avatars = glob(get_module('User').'/assets/images/avatars/*');
        foreach ($avatars as $i => $avatar) {
            $avatar = basename($avatar);
            $this->avatars[$i]['name'] = ucwords(rtrim($avatar, '/(.jpg|.png)/'));
            $this->avatars[$i]['avatar'] = assets("user/images/avatars/$avatar");
        }

        return $this->avatars;
    }

    /**
     * Overrides the avatar column to use a default image
     * if column is null.
     *
     * @return string
     */
    public function getDisplayavatarAttribute()
    {
        $gender = ! is_null($this->detail('gender'))
                  ? $this->detail('gender')
                  : 'neutral';
        return $this->avatar ?? assets("user/images/avatars/{$gender}.png");
    }
}
