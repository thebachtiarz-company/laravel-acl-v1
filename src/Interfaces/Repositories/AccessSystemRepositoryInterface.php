<?php

namespace App\Libraries\MyACL\Interfaces\Repositories;

use TheBachtiarz\Base\Interfaces\Repositories\RepositoryInterface;

interface AccessSystemRepositoryInterface extends RepositoryInterface
{
    /**
     * Find by code
     *
     * @param string $code
     * @return \App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface|null
     */
    public function findByCode(string $code): ?\App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface;

    /**
     * Find by address
     *
     * @param string $address
     * @return \App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface|null
     */
    public function findByAddress(string $address): ?\App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface;

    /**
     * Find by address or create new
     *
     * @param string $address
     * @return \App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface
     */
    public function findAddressOrCreate(string $address): \App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface;
}
