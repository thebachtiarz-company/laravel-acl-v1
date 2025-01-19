<?php

namespace TheBachtiarz\ACL\Interfaces\Services;

use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Interfaces\Services\ServiceInterface;

interface AccessManagerServiceInterface extends ServiceInterface
{
    /**
     * Create or update access manager
     *
     * @param \TheBachtiarz\ACL\DTO\Services\AccessManagerMutationInputDTO $input
     * @return ResponseDataDTO
     */
    public function createOrUpdate(\TheBachtiarz\ACL\DTO\Services\AccessManagerMutationInputDTO $input): ResponseDataDTO;
}
