<?php

namespace TheBachtiarz\ACL\Helpers\Models;

use Illuminate\Support\Str;
use TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
use TheBachtiarz\ACL\Interfaces\Repositories\SourceAccessRepositoryInterface;

class SourceAccessModelHelper
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
            SourceAccessInterface::CODE_PREFIX,
            Str::ulid()->toBase58(),
        );
    }

    /**
     * Get as list option
     *
     * @return array
     */
    public static function getListOption(): array
    {
        return static::repository()->collection()
            ->pluck(SourceAccessInterface::ATTRIBUTE_NAME, app(SourceAccessInterface::class)->getPrimaryKeyAttribute())
            ->toArray();
    }

    /**
     * Repository
     *
     * @return SourceAccessRepositoryInterface
     */
    private static function repository(): SourceAccessRepositoryInterface
    {
        return app(SourceAccessRepositoryInterface::class);
    }
}
