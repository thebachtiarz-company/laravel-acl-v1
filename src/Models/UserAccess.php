<?php

namespace TheBachtiarz\ACL\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;
use TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
use TheBachtiarz\ACL\Interfaces\Models\UserAccessInterface;
use TheBachtiarz\ACL\Models\Factory\UserAccessFactory;
use TheBachtiarz\Base\Models\AbstractModel;
use TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface;
use TheBachtiarz\OAuth\Models\AuthUser;

class UserAccess extends AbstractModel implements UserAccessInterface
{
    public function __construct(array $attributes = [])
    {
        $this->setTable(self::TABLE_NAME);
        $this->fillable(self::ATTRIBUTE_FILLABLE);

        $this->modelFactory = UserAccessFactory::class;

        parent::__construct($attributes);
    }

    // ? Public Methods

    // ? Protected Methods

    // ? Private Methods

    // ? Maps

    #[\Override]
    public function simpleListMap(array $attributes = [], array $hides = []): array
    {
        $map = [];

        foreach ($map as $key => $value) {
            $this->setData(attribute: $key, value: $value);
        }

        $attributes = array_unique(array_merge($attributes, array_keys($map)));

        $hides = array_unique(array_merge($hides, [
            'deleted_at',
        ]));

        return parent::simpleListMap(attributes: $attributes, hides: $hides);
    }

    // ? Relation

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: AuthUser::class,
            foreignKey: self::ATTRIBUTE_USER_ID,
            ownerKey: app(AuthUserInterface::class)->getPrimaryKeyAttribute(),
        );
    }

    public function sourceAccess(): BelongsTo
    {
        return $this->belongsTo(
            related: SourceAccess::class,
            foreignKey: self::ATTRIBUTE_SOURCE_ACCESS_ID,
            ownerKey: app(SourceAccessInterface::class)->getPrimaryKeyAttribute(),
        );
    }

    public function accessManager(): BelongsTo
    {
        return $this->belongsTo(
            related: AccessManager::class,
            foreignKey: self::ATTRIBUTE_ACCESS_MANAGER_ID,
            ownerKey: app(AccessManagerInterface::class)->getPrimaryKeyAttribute(),
        );
    }

    // ? Getter Modules

    public function getUserId(): int
    {
        return $this->{self::ATTRIBUTE_USER_ID};
    }

    public function getSourceAccessId(): int
    {
        return $this->{self::ATTRIBUTE_SOURCE_ACCESS_ID};
    }

    public function getAccessManagerId(): int
    {
        return $this->{self::ATTRIBUTE_ACCESS_MANAGER_ID};
    }

    public function getGrantedBy(): string
    {
        return $this->{self::ATTRIBUTE_GRANTED_BY};
    }

    // ? Setter Modules

    public function setUserId(int $userId): self
    {
        $this->{self::ATTRIBUTE_USER_ID} = $userId;

        return $this;
    }

    public function setSourceAccessId(int $sourceAccessId): self
    {
        $this->{self::ATTRIBUTE_SOURCE_ACCESS_ID} = $sourceAccessId;

        return $this;
    }

    public function setAccessManagerId(int $accessManagerId): self
    {
        $this->{self::ATTRIBUTE_ACCESS_MANAGER_ID} = $accessManagerId;

        return $this;
    }

    public function setGrantedBy(string $grantedBy): self
    {
        $this->{self::ATTRIBUTE_GRANTED_BY} = $grantedBy;

        return $this;
    }
}
