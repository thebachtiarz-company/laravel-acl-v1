<?php

namespace TheBachtiarz\ACL\Interfaces\Repositories;

use TheBachtiarz\Base\Interfaces\Repositories\RepositoryInterface;

interface AccessManagerRepositoryInterface extends RepositoryInterface
{
    /**
     * Find by code
     *
     * @param string $code
     * @return \TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface|null
     */
    public function findByCode(string $code): ?\TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;

    /**
     * Get by source
     *
     * @param \TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface $source
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBySource(\TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface $source): \Illuminate\Database\Eloquent\Collection;
}
