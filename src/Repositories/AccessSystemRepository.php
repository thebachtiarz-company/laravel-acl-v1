<?php

namespace App\Libraries\MyACL\Repositories;

use App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface;
use App\Libraries\MyACL\Interfaces\Repositories\AccessSystemRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TheBachtiarz\Base\Repositories\AbstractRepository;

class AccessSystemRepository extends AbstractRepository implements AccessSystemRepositoryInterface
{
    public function __construct()
    {
        $this->setModelEntity(AccessSystemInterface::class);

        parent::__construct();
    }

    public function findByCode(string $code): ?AccessSystemInterface
    {
        return $this->modelBuilder(
            modelBuilder: $this->modelEntity::query()->getByAttribute(AccessSystemInterface::ATTRIBUTE_CODE, $code),
        )->getBuilderEntity($code);
    }

    public function findByAddress(string $address): ?AccessSystemInterface
    {
        return $this->modelBuilder(
            modelBuilder: $this->modelEntity::query()->getByAttribute(AccessSystemInterface::ATTRIBUTE_ADDRESS, $address),
        )->getBuilderEntity($address);
    }

    public function findAddressOrCreate(string $address): AccessSystemInterface
    {
        $entity = $this->throwIfNullEntity(false)->findByAddress($address);

        if (!$entity) {
            $entity = $this->createOrUpdate(
                app(AccessSystemInterface::class)
                    ->setAddress($address)
                    ->setName(Str::replace('::', '-', $address))
                    ->setAccess([])
                    ->setCreatedBy(Auth::hasUser() ? Auth::user()->{\TheBachtiarz\OAuth\Helpers\AuthUserHelper::authMethod()} : 'Anonymous'),
            );

            assert($entity instanceof AccessSystemInterface);
        }

        return $entity;
    }
}
