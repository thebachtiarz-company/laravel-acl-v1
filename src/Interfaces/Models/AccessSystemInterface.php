<?php

namespace App\Libraries\MyACL\Interfaces\Models;

use TheBachtiarz\Base\Interfaces\Models\ModelInterface;

interface AccessSystemInterface extends ModelInterface
{
    /**
     * Model table name
     */
    public const string TABLE_NAME = 'access_systems';

    /**
     * Attributes fillable
     */
    public const array ATTRIBUTE_FILLABLE = [
        self::ATTRIBUTE_CODE,
        self::ATTRIBUTE_ADDRESS,
        self::ATTRIBUTE_NAME,
        self::ATTRIBUTE_DESCRIPTION,
        self::ATTRIBUTE_ACCESS,
        self::ATTRIBUTE_CREATED_BY,
    ];

    public const string ATTRIBUTE_CODE = 'code';
    public const string ATTRIBUTE_ADDRESS = 'address';
    public const string ATTRIBUTE_NAME = 'name';
    public const string ATTRIBUTE_DESCRIPTION = 'description';
    public const string ATTRIBUTE_ACCESS = 'access';
    public const string ATTRIBUTE_CREATED_BY = 'created_by';

    public const string CODE_PREFIX = 'ACS';

    // ? Relation

    // ? Getter Modules

    /**
     * Get code.
     *
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * Get address.
     *
     * @return string|null
     */
    public function getAddress(): ?string;

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Get access.
     *
     * @return array<int,string>|null
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
     * Set address.
     *
     * @param string $address
     * @return self
     */
    public function setAddress(string $address): self;

    /**
     * Set name.
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self;

    /**
     * Set description.
     *
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description = null): self;

    /**
     * Set access.
     *
     * @param array<int,string> $access
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
