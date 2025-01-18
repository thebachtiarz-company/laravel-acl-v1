<?php

namespace App\Libraries\MyACL\Helpers\Models;

use App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface;
use Illuminate\Support\Str;

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
