<?php

namespace TheBachtiarz\ACL\Http\Requests\Rules;

use TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;
use TheBachtiarz\Base\Http\Requests\Rules\AbstractRule;

class AccessManagerCodeRule extends AbstractRule
{
    public const ACCESS_MANAGER_CODE = 'accessManagerCode';

    #[\Override]
    public static function rules(): array
    {
        return [
            self::ACCESS_MANAGER_CODE => [
                'required',
                'alpha_num:ascii',
                'starts_with:' . AccessManagerInterface::CODE_PREFIX,
            ],
        ];
    }

    #[\Override]
    public static function messages(): array
    {
        return [
            sprintf('%s.*', self::ACCESS_MANAGER_CODE) => 'Access Manager code invalid',
        ];
    }
}
