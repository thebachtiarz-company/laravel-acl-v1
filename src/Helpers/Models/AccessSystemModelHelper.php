<?php

namespace TheBachtiarz\ACL\Helpers\Models;

use Illuminate\Support\Str;
use TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface;

class AccessSystemModelHelper
{
    /**
     * Generate new code
     *
     * @return string
     */
    public static function generateCode(): string
    {
        return sprintf(
            '%s%s',
            AccessSystemInterface::CODE_PREFIX,
            Str::ulid()->toBase58(),
        );
    }
}
