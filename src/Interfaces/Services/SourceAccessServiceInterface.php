<?php

namespace TheBachtiarz\ACL\Interfaces\Services;

use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Interfaces\Services\ServiceInterface;

interface SourceAccessServiceInterface extends ServiceInterface
{
    /**
     * Create or update source access
     *
     * @param \TheBachtiarz\ACL\DTO\Services\SourceAccessMutationInputDTO $input
     * @return ResponseDataDTO
     */
    public function createOrUpdate(\TheBachtiarz\ACL\DTO\Services\SourceAccessMutationInputDTO $input): ResponseDataDTO;
}
