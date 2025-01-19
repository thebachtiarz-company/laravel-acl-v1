<?php

namespace TheBachtiarz\ACL\DTO\Services;

use TheBachtiarz\Base\DTOs\AbstractDTO;

class UserAccessMutationInputDTO extends AbstractDTO
{
    /**
     * User access mutation input
     *
     * @param integer $userId
     * @param integer $sourceAccessId
     * @param integer $accessManagerId
     */
    public function __construct(
        public readonly int $userId,
        public readonly int $sourceAccessId,
        public readonly int $accessManagerId,
    ) {}
}
