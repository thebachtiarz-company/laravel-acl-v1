<?php

namespace App\Libraries\MyACL\Interfaces\Services;

use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Interfaces\Services\ServiceInterface;

interface AccessSystemServiceInterface extends ServiceInterface
{
    /**
     * Create or update access system
     *
     * @param \App\Libraries\MyACL\DTO\Services\AccessSystemMutationInputDTO $input
     * @return ResponseDataDTO
     */
    public function createOrUpdate(\App\Libraries\MyACL\DTO\Services\AccessSystemMutationInputDTO $input): ResponseDataDTO;
}
