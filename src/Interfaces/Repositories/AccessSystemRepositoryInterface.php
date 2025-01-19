<?php

namespace TheBachtiarz\ACL\Interfaces\Repositories;

use TheBachtiarz\Base\Interfaces\Repositories\RepositoryInterface;

interface AccessSystemRepositoryInterface extends RepositoryInterface
{
    /**
     * Find by code
     *
     * @param string $code
     * @return \TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface|null
     */
    public function findByCode(string $code): ?\TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface;

    /**
     * Find by address
     *
     * @param string $address
     * @return \TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface|null
     */
    public function findByAddress(string $address): ?\TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface;

    /**
     * Find by address or create new
     *
     * @param string $address
     * @return \TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface
     */
    public function findAddressOrCreate(string $address): \TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface;
}
