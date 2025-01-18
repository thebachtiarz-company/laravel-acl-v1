<?php

namespace App\Libraries\MyACL\Interfaces\Repositories;

use TheBachtiarz\Base\Interfaces\Repositories\RepositoryInterface;

interface UserAccessRepositoryInterface extends RepositoryInterface
{
    /**
     * Get belongs to user
     *
     * @param \TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface $user
     * @return \Illuminate\Database\Eloquent\Collection<\App\Libraries\MyACL\Interfaces\Models\UserAccessInterface>
     */
    public function getBelongsToUser(\TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface $user): \Illuminate\Database\Eloquent\Collection;

    /**
     * Find user access
     *
     * @param \TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface $user
     * @param \App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface $source
     * @return \App\Libraries\MyACL\Interfaces\Models\UserAccessInterface|null
     */
    public function findUserAccess(\TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface $user, \App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface $source): ?\App\Libraries\MyACL\Interfaces\Models\UserAccessInterface;
}
