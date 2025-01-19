<?php

namespace TheBachtiarz\ACL\Interfaces\Services;

use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Interfaces\Services\ServiceInterface;

interface AccessSystemServiceInterface extends ServiceInterface
{
    /**
     * Create or update access system
     *
     * @param \TheBachtiarz\ACL\DTO\Services\AccessSystemMutationInputDTO $input
     * @return ResponseDataDTO
     */
    public function createOrUpdate(\TheBachtiarz\ACL\DTO\Services\AccessSystemMutationInputDTO $input): ResponseDataDTO;
}
