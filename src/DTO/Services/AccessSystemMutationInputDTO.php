<?php

namespace App\Libraries\MyACL\DTO\Services;

use TheBachtiarz\Base\DTOs\AbstractDTO;

class AccessSystemMutationInputDTO extends AbstractDTO
{
    /**
     * Access system mutation input
     *
     * @param string $address
     * @param string $name
     * @param array<int,string> $access
     * @param string|null $description
     * @param string|null $code
     */
    public function __construct(
        public readonly string $address,
        public readonly string $name,
        public readonly array $access,
        public ?string $description = null,
        public ?string $code = null,
    ) {}
}
