<?php

namespace App\Libraries\MyACL\Interfaces\Services;

use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Interfaces\Services\ServiceInterface;

interface SourceAccessServiceInterface extends ServiceInterface
{
    /**
     * Create or update source access
     *
     * @param \App\Libraries\MyACL\DTO\Services\SourceAccessMutationInputDTO $input
     * @return ResponseDataDTO
     */
    public function createOrUpdate(\App\Libraries\MyACL\DTO\Services\SourceAccessMutationInputDTO $input): ResponseDataDTO;
}
