<?php

namespace TheBachtiarz\ACL\Interfaces\Models;

use TheBachtiarz\Base\Interfaces\Models\ModelInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface AccessManagerInterface extends ModelInterface
{
    /**
     * Model table name
     */
    public const string TABLE_NAME = 'access_managers';

    /**
     * Attributes fillable
     */
    public const array ATTRIBUTE_FILLABLE = [
        self::ATTRIBUTE_SOURCE_ACCESS_ID,
        self::ATTRIBUTE_CODE,
        self::ATTRIBUTE_NAME,
        self::ATTRIBUTE_ACCESS,
        self::ATTRIBUTE_CREATED_BY,
    ];

    public const string ATTRIBUTE_SOURCE_ACCESS_ID = 'source_access_id';
    public const string ATTRIBUTE_CODE = 'code';
    public const string ATTRIBUTE_NAME = 'name';
    public const string ATTRIBUTE_ACCESS = 'access';
    public const string ATTRIBUTE_CREATED_BY = 'created_by';

    public const CODE_PREFIX = 'ACM';

    // ? Relation

    /**
     * Define a relationship to the source access.
     *
     * @return BelongsTo
     */
    public function sourceAccess(): BelongsTo;

    // ? Getter Modules

    /**
     * Get source access id
     *
     * @return int|null
     */
    public function getSourceAccessId(): ?int;

    /**
     * Get code
     *
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Get access
     *
     * @return array<int,string>|null
     */
    public function getAccess(): ?array;

    /**
     * Get created by
     *
     * @return string|null
     */
    public function getCreatedBy(): ?string;

    // ? Setter Modules

    /**
     * Set source id
     *
     * @param int $sourceAccessId
     * @return self
     */
    public function setSourceAccessId(int $sourceAccessId): self;

    /**
     * Set code
     *
     * @param string $code
     * @return self
     */
    public function setCode(string $code): self;

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self;

    /**
     * Set access
     *
     * @param array<int,string> $access
     * @return self
     */
    public function setAccess(array $access): self;

    /**
     * Set created by
     *
     * @param string $createdBy
     * @return self
     */
    public function setCreatedBy(string $createdBy): self;
}
