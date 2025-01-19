<?php

namespace TheBachtiarz\ACL\Interfaces\Models;

use TheBachtiarz\Base\Interfaces\Models\ModelInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface UserAccessInterface extends ModelInterface
{
    /**
     * Model table name
     */
    public const string TABLE_NAME = 'user_accesses';

    /**
     * Attributes fillable
     */
    public const array ATTRIBUTE_FILLABLE = [
        self::ATTRIBUTE_USER_ID,
        self::ATTRIBUTE_SOURCE_ACCESS_ID,
        self::ATTRIBUTE_ACCESS_MANAGER_ID,
        self::ATTRIBUTE_GRANTED_BY,
    ];

    public const string ATTRIBUTE_USER_ID = 'auth_user_id';
    public const string ATTRIBUTE_SOURCE_ACCESS_ID = 'source_access_id';
    public const string ATTRIBUTE_ACCESS_MANAGER_ID = 'access_manager_id';
    public const string ATTRIBUTE_GRANTED_BY = 'granted_by';

    // ? Relation

    /**
     * Get user that owns the access.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo;

    /**
     * Get source access.
     *
     * @return BelongsTo
     */
    public function sourceAccess(): BelongsTo;

    /**
     * Get access manager.
     *
     * @return BelongsTo
     */
    public function accessManager(): BelongsTo;

    // ? Getter Modules

    /**
     * Get user ID.
     *
     * @return int
     */
    public function getUserId(): int;

    /**
     * Get source access ID.
     *
     * @return int
     */
    public function getSourceAccessId(): int;

    /**
     * Get access manager ID.
     *
     * @return int
     */
    public function getAccessManagerId(): int;

    /**
     * Get access granted by.
     *
     * @return string
     */
    public function getGrantedBy(): string;

    // ? Setter Modules

    /**
     * Set user ID.
     *
     * @param int $userId
     * @return self
     */
    public function setUserId(int $userId): self;

    /**
     * Set source access ID.
     *
     * @param int $sourceAccessId
     * @return self
     */
    public function setSourceAccessId(int $sourceAccessId): self;

    /**
     * Set access manager ID.
     *
     * @param int $accessManagerId
     * @return self
     */
    public function setAccessManagerId(int $accessManagerId): self;

    /**
     * Set access granted by.
     *
     * @param string $grantedBy
     * @return self
     */
    public function setGrantedBy(string $grantedBy): self;
}
