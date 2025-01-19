<?php

namespace TheBachtiarz\ACL\Interfaces\Repositories;

use TheBachtiarz\Base\Interfaces\Repositories\RepositoryInterface;

interface SourceAccessRepositoryInterface extends RepositoryInterface
{
    /**
     * Find by code
     *
     * @param string $code
     * @return \TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface|null
     */
    public function findByCode(string $code): ?\TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
}
