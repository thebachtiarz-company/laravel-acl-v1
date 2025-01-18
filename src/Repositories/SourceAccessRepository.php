<?php

namespace App\Libraries\MyACL\Repositories;

use App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface;
use App\Libraries\MyACL\Interfaces\Repositories\SourceAccessRepositoryInterface;
use TheBachtiarz\Base\Repositories\AbstractRepository;

class SourceAccessRepository extends AbstractRepository implements SourceAccessRepositoryInterface
{
    public function __construct()
    {
        $this->setModelEntity(SourceAccessInterface::class);

        parent::__construct();
    }

    public function findByCode(string $code): ?SourceAccessInterface
    {
        return $this->modelBuilder(
            modelBuilder: $this->modelEntity::query()->getByAttribute(SourceAccessInterface::ATTRIBUTE_CODE, $code),
        )->getBuilderEntity($code);
    }
}
