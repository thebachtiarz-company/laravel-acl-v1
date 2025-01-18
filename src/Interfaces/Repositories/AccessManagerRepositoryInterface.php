<?php

namespace App\Libraries\MyACL\Interfaces\Repositories;

use TheBachtiarz\Base\Interfaces\Repositories\RepositoryInterface;

interface AccessManagerRepositoryInterface extends RepositoryInterface
{
    /**
     * Find by code
     *
     * @param string $code
     * @return \App\Libraries\MyACL\Interfaces\Models\AccessManagerInterface|null
     */
    public function findByCode(string $code): ?\App\Libraries\MyACL\Interfaces\Models\AccessManagerInterface;

    /**
     * Get by source
     *
     * @param \App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface $source
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBySource(\App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface $source): \Illuminate\Database\Eloquent\Collection;
}
