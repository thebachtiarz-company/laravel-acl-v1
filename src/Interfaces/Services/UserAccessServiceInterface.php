<?php

namespace TheBachtiarz\ACL\Interfaces\Services;

use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Interfaces\Services\ServiceInterface;

interface UserAccessServiceInterface extends ServiceInterface
{
    /**
     * Create or replace user access
     *
     * @param \TheBachtiarz\ACL\DTO\Services\UserAccessMutationInputDTO $input
     * @return ResponseDataDTO
     */
    public function createOrReplace(\TheBachtiarz\ACL\DTO\Services\UserAccessMutationInputDTO $input): ResponseDataDTO;
}
