<?php

namespace Pluma\Support\Auth\Traits;

use Closure;
use Parchment\Helpers\Word;

trait UserMutator
{
    /**
     * Array of roles.
     *
     * @var array
     */
    protected $rolesnames;

    /**
     * Get the mutated handlename.
     *
     * @return string
     */
    public function getHandlenameAttribute()
    {
        return (isset($this->username) ? $this->username : studly_case("$this->firstname $this->lastname"));
    }

    /**
     * Get the mutated array of roles.
     *
     * @return string
     */
    public function getDisplayroleAttribute()
    {
        if (isset($this->roles)) {
            foreach ($this->roles as $role) {
                $this->rolesnames[$role->alias] = $role->alias;
            }
        } else {
            $this->rolesnames[] = __('Guest');
        }

        return implode(" / ", (array) $this->rolesnames);
    }

    /**
     * Get the mutated firstname, middlename, lastname role.
     *
     * @return string
     */
    public function getFullnameAttribute()
    {
        $name = [];
        $this->prefixname ? $name[] = $this->prefixname : '';
        $this->firstname ? $name[] = $this->firstname : '';
        $name[] = $this->lastname;
        $name = trim(implode(" ", $name));

        return ! empty($name) ? $name : $this->username;
    }

    /**
     * Get the mutated lastname, firstname.
     *
     * @return string
     */
    public function getPropernameAttribute()
    {
        $name[] = $this->lastname ? "$this->lastname, " : '';
        $name[] = $this->firstname;
        $name = trim(implode(" ", $name));

        return ! empty($name) ? $name : $this->username;
    }

    /**
     * Get the mutated display name.
     *
     * @return string
     */
    public function getDisplaynameAttribute()
    {
        $displayname = settings('display_name', "%firstname% %middleinitial% %lastname%");
        $displayname = preg_replace('/%firstname%/', $this->firstname, $displayname);
        $displayname = preg_replace('/%lastname%/', $this->lastname, $displayname);
        $displayname = preg_replace('/%middlename%/', $this->middlename, $displayname);
        $displayname = preg_replace('/%prefixname%/', $this->firstname, $displayname);
        $displayname = preg_replace('/%middleinitial%/', Word::acronym($this->middlename, $this->middlename ? true : false), $displayname);
        $displayname = preg_replace('/%firstinitial%/', Word::acronym($this->firstname, $this->firstname ? true : false), $displayname);
        $displayname = preg_replace('/%lastinitial%/', Word::acronym($this->lastname, $this->lastname ? true : false), $displayname);
        $displayname = preg_replace('/%fullname%/', $this->fullname, $displayname);
        $displayname = preg_replace('/%propername%/', $this->propername, $displayname);

        return ! empty(trim($displayname)) ? $displayname : $this->username;
    }

    /**
     * Get the mutated nickname.
     *
     * @return string
     */
    public function getNicknameAttribute()
    {
        return isset($this->details->nickname) ? $this->details->nickname : $this->firstname;
    }

    /**
     * Gets the mutated bio of the resource.
     *
     * @return string
     */
    public function getBioAttribute()
    {
        $placeholder = $this->id == user()->id ? __("A short description about yourself will look nice here.") : __("The user haven't shared their bio yet.");
        return isset($this->details) && ! empty($this->details->bio) ? $this->details->bio : $placeholder;
    }

    /**
     * Gets the mutated email of the resource.
     *
     * @return string
     */
    public function getDisplayemailAttribute()
    {
        return ! (bool) $this->setting('keep_email_private', false)
                ? $this->email
                : '';
    }
}
