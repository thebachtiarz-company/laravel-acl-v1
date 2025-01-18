<?php

namespace App\Libraries\MyACL\Interfaces\Services;

use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Interfaces\Services\ServiceInterface;

interface UserAccessServiceInterface extends ServiceInterface
{
    /**
     * Create or replace user access
     *
     * @param \App\Libraries\MyACL\DTO\Services\UserAccessMutationInputDTO $input
     * @return ResponseDataDTO
     */
    public function createOrReplace(\App\Libraries\MyACL\DTO\Services\UserAccessMutationInputDTO $input): ResponseDataDTO;
}
