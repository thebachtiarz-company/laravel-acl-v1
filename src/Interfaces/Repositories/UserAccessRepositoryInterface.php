<?php

namespace TheBachtiarz\ACL\Interfaces\Repositories;

use TheBachtiarz\Base\Interfaces\Repositories\RepositoryInterface;

interface UserAccessRepositoryInterface extends RepositoryInterface
{
    /**
     * Get belongs to user
     *
     * @param \TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface $user
     * @return \Illuminate\Database\Eloquent\Collection<\TheBachtiarz\ACL\Interfaces\Models\UserAccessInterface>
     */
    public function getBelongsToUser(\TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface $user): \Illuminate\Database\Eloquent\Collection;

    /**
     * Find user access
     *
     * @param \TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface $user
     * @param \TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface $source
     * @return \TheBachtiarz\ACL\Interfaces\Models\UserAccessInterface|null
     */
    public function findUserAccess(\TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface $user, \TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface $source): ?\TheBachtiarz\ACL\Interfaces\Models\UserAccessInterface;
}
