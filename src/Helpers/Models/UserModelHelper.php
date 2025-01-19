<?php

namespace TheBachtiarz\ACL\Helpers\Models;

use TheBachtiarz\OAuth\Helpers\AuthUserHelper;
use TheBachtiarz\OAuth\Models\AuthUser;

class UserModelHelper
{
    /**
     * Get user list option
     *
     * @return array
     */
    public static function getListOption(): array
    {
        return AuthUser::all()->pluck(AuthUserHelper::authMethod(), (new AuthUser())->getPrimaryKeyAttribute())->all();
    }
}
