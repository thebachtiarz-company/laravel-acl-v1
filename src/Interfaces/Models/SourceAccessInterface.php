<?php

namespace App\Libraries\MyACL\Interfaces\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use TheBachtiarz\Base\Interfaces\Models\ModelInterface;

interface SourceAccessInterface extends ModelInterface
{
    /**
     * Model table name
     */
    public const string TABLE_NAME = 'source_accesses';

    /**
     * Attributes fillable
     */
    public const array ATTRIBUTE_FILLABLE = [
        self::ATTRIBUTE_CODE,
        self::ATTRIBUTE_NAME,
        self::ATTRIBUTE_ACCESS,
        self::ATTRIBUTE_CREATED_BY,
    ];

    public const string ATTRIBUTE_CODE = 'code';
    public const string ATTRIBUTE_NAME = 'name';
    public const string ATTRIBUTE_ACCESS = 'access';
    public const string ATTRIBUTE_CREATED_BY = 'created_by';

    public const string CODE_PREFIX = 'SOA';

    // ? Relation

    /**
     * Get access managers relation.
     *
     * @return HasMany
     */
    public function accessManagers(): HasMany;

    /**
     * Get user accesses relation.
     *
     * @return HasMany
     */
    public function userAccesses(): HasMany;

    // ? Getter Modules

    /**
     * Get code.
     *
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Get access.
     *
     * @return array|null
     */
    public function getAccess(): ?array;

    /**
     * Get created by.
     *
     * @return string|null
     */
    public function getCreatedBy(): ?string;

    // ? Setter Modules

    /**
     * Set code.
     *
     * @param string $code
     * @return self
     */
    public function setCode(string $code): self;

    /**
     * Set name.
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self;

    /**
     * Set access.
     *
     * @param array $access
     * @return self
     */
    public function setAccess(array $access): self;

    /**
     * Set created by.
     *
     * @param string $createdBy
     * @return self
     */
    public function setCreatedBy(string $createdBy): self;
}
