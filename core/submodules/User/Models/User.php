<?php

namespace User\Models;

use Pluma\Support\Auth\User as Authenticatable;
use Pluma\Support\Token\Traits\TokenizableTrait;
use Role\Support\Relations\BelongsToManyRoles;
use Role\Support\Relations\HasManyPermissionsThroughRoles;
use Setting\Support\Relations\HasManySettings;
use Setting\Support\Traits\WhereSettingTrait;
use User\Support\Accessors\UserAccessor;
use User\Support\Relations\HasManyDetails;
use User\Support\Traits\CanResetPasswordTrait;
use User\Support\Traits\WhereDetailTrait;

class User extends Authenticatable
{
    use BelongsToManyRoles,
        CanResetPasswordTrait,
        HasManyDetails,
        UserAccessor,
        HasManyPermissionsThroughRoles,
        HasManySettings,
        TokenizableTrait,
        WhereDetailTrait,
        WhereSettingTrait;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'username',
        'prefixname',
        'email',
        'password',
    ];

    protected $searchables = [
        'firstname',
        'middlename',
        'lastname',
        'username',
        'prefixname',
        'email',
    ];
}
