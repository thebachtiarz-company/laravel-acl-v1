<?php

namespace App\Libraries\MyACL\Repositories;

use App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface;
use App\Libraries\MyACL\Interfaces\Models\UserAccessInterface;
use App\Libraries\MyACL\Interfaces\Repositories\UserAccessRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use TheBachtiarz\Base\Repositories\AbstractRepository;
use TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface;

class UserAccessRepository extends AbstractRepository implements UserAccessRepositoryInterface
{
    public function __construct()
    {
        $this->setModelEntity(UserAccessInterface::class);

        parent::__construct();
    }

    public function getBelongsToUser(AuthUserInterface $user): Collection
    {
        return $this->modelBuilder(
            modelBuilder: $this->modelEntity::query()
                ->where(column: UserAccessInterface::ATTRIBUTE_USER_ID, operator: '=', value: $user->getId()),
        )->getBuilderCollection();
    }

    public function findUserAccess(AuthUserInterface $user, SourceAccessInterface $source): ?UserAccessInterface
    {
        return $this->modelBuilder(
            modelBuilder: $this->modelEntity::query()
                ->where(column: UserAccessInterface::ATTRIBUTE_USER_ID, operator: '=', value: $user->getId())
                ->where(column: UserAccessInterface::ATTRIBUTE_SOURCE_ACCESS_ID, operator: '=', value: $source->getId()),
        )->getBuilderEntity();
    }
}
