<?php

namespace App\Libraries\MyACL\DTO\Services;

use TheBachtiarz\Base\DTOs\AbstractDTO;

class SourceAccessMutationInputDTO extends AbstractDTO
{
    /**
     * Source access mutation input
     *
     * @param string $name
     * @param array<string,array<int,string>> $access
     * @param string|null $code
     */
    public function __construct(
        public readonly string $name,
        public readonly array $access,
        public ?string $code = null,
    ) {}
}
