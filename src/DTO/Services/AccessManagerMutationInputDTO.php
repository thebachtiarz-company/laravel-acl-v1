<?php

namespace App\Libraries\MyACL\DTO\Services;

use TheBachtiarz\Base\DTOs\AbstractDTO;

class AccessManagerMutationInputDTO extends AbstractDTO
{
    /**
     * Access manager mutation input
     *
     * @param integer $sourceId
     * @param string $name
     * @param array<int,string> $access
     * @param string|null $code
     */
    public function __construct(
        public readonly int $sourceId,
        public readonly string $name,
        public readonly array $access,
        public ?string $code = null,
    ) {}
}
