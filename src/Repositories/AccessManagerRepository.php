<?php

namespace TheBachtiarz\ACL\Repositories;

use Illuminate\Database\Eloquent\Collection;
use TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;
use TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
use TheBachtiarz\ACL\Interfaces\Repositories\AccessManagerRepositoryInterface;
use TheBachtiarz\Base\Repositories\AbstractRepository;

class AccessManagerRepository extends AbstractRepository implements AccessManagerRepositoryInterface
{
    public function __construct()
    {
        $this->setModelEntity(AccessManagerInterface::class);

        parent::__construct();
    }

    public function findByCode(string $code): ?AccessManagerInterface
    {
        return $this->modelBuilder(
            modelBuilder: $this->modelEntity::query()->getByAttribute(AccessManagerInterface::ATTRIBUTE_CODE, $code),
        )->getBuilderEntity($code);
    }

    public function getBySource(SourceAccessInterface $source): Collection
    {
        return $this->modelBuilder(
            modelBuilder: $this->modelEntity::query()->where(column: AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID, operator: '=', value: $source->getId()),
        )->getBuilderCollection();
    }
}
