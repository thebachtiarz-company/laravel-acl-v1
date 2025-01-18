<?php

namespace App\Libraries\MyACL\Interfaces\Services;

use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Interfaces\Services\ServiceInterface;

interface AccessManagerServiceInterface extends ServiceInterface
{
    /**
     * Create or update access manager
     *
     * @param \App\Libraries\MyACL\DTO\Services\AccessManagerMutationInputDTO $input
     * @return ResponseDataDTO
     */
    public function createOrUpdate(\App\Libraries\MyACL\DTO\Services\AccessManagerMutationInputDTO $input): ResponseDataDTO;
}
