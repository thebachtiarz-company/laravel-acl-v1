<?php

namespace App\Libraries\MyACL\Helpers\Models;

use App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface;
use App\Libraries\MyACL\Interfaces\Repositories\SourceAccessRepositoryInterface;
use Illuminate\Support\Str;

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
