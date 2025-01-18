<?php

namespace App\Libraries\MyACL\Interfaces\Repositories;

use TheBachtiarz\Base\Interfaces\Repositories\RepositoryInterface;

interface SourceAccessRepositoryInterface extends RepositoryInterface
{
    /**
     * Find by code
     *
     * @param string $code
     * @return \App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface|null
     */
    public function findByCode(string $code): ?\App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface;
}
