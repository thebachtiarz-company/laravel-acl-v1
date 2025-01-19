<?php

namespace TheBachtiarz\ACL\Helpers\Models;

use Illuminate\Support\Str;
use TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;
use TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
use TheBachtiarz\ACL\Interfaces\Repositories\AccessManagerRepositoryInterface;
use TheBachtiarz\ACL\Interfaces\Repositories\SourceAccessRepositoryInterface;

class AccessManagerModelHelper
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
            AccessManagerInterface::CODE_PREFIX,
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
            ->pluck(AccessManagerInterface::ATTRIBUTE_NAME, app(AccessManagerInterface::class)->getPrimaryKeyAttribute())
            ->toArray();
    }

    /**
     * Get list by source id
     *
     * @param integer $sourceId
     * @return array
     */
    public static function getListOptionBySourceId(int $sourceId): array
    {
        $source = app(SourceAccessRepositoryInterface::class)->throwIfNullEntity(false)->getByPrimaryKey($sourceId);

        if (!$source) {
            return [];
        }

        return static::getBySource($source)
            ->pluck(AccessManagerInterface::ATTRIBUTE_NAME, app(AccessManagerInterface::class)->getPrimaryKeyAttribute())
            ->toArray();
    }

    /**
     * Get by source
     *
     * @param SourceAccessInterface $source
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getBySource(SourceAccessInterface $source): \Illuminate\Database\Eloquent\Collection
    {
        return static::repository()->throwIfNullEntity(false)->getBySource($source);
    }

    /**
     * Find by code
     *
     * @param string $code
     * @return AccessManagerInterface|null
     */
    public static function findByCode(string $code): ?AccessManagerInterface
    {
        return static::repository()->throwIfNullEntity(false)->findByCode($code);
    }

    /**
     * Repository
     *
     * @return AccessManagerRepositoryInterface
     */
    private static function repository(): AccessManagerRepositoryInterface
    {
        return app(AccessManagerRepositoryInterface::class);
    }
}
