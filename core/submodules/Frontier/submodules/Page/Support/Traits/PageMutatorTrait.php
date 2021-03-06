<?php

namespace Page\Support\Traits;

use Crowfeather\Traverser\Traverser;

trait PageMutatorTrait
{
    /**
     * Gets the user's displayname.
     *
     * @return string
     */
    public function getAuthorAttribute()
    {
        return ! $this->user ?: $this->user->displayname;
    }

    public function getAuthoravatarAttribute()
    {
        return ! $this->user ?: $this->user->displayavatar;
    }
}
