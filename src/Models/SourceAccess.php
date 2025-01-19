<?php

namespace TheBachtiarz\ACL\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use TheBachtiarz\ACL\Helpers\Models\SourceAccessModelHelper;
use TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
use TheBachtiarz\ACL\Models\Factory\SourceAccessFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TheBachtiarz\Base\Models\AbstractModel;

class SourceAccess extends AbstractModel implements SourceAccessInterface
{
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        $this->setTable(self::TABLE_NAME);
        $this->fillable(self::ATTRIBUTE_FILLABLE);
        $this->mergeCasts([
            self::ATTRIBUTE_ACCESS => 'array',
        ]);

        $this->modelFactory = SourceAccessFactory::class;

        parent::__construct($attributes);
    }

    // ? Public Methods

    #[\Override]
    public function save(array $options = [])
    {
        if (!$this->getId()) {
            $this->{self::ATTRIBUTE_CODE} ??= SourceAccessModelHelper::generateCode();
        }

        return parent::save(options: $options);
    }

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

    public function accessManagers(): HasMany
    {
        return $this->hasMany(
            related: AccessManager::class,
            foreignKey: AccessManager::ATTRIBUTE_SOURCE_ACCESS_ID,
            localKey: $this->getPrimaryKeyAttribute(),
        );
    }

    public function userAccesses(): HasMany
    {
        return $this->hasMany(
            related: UserAccess::class,
            foreignKey: UserAccess::ATTRIBUTE_SOURCE_ACCESS_ID,
            localKey: $this->getPrimaryKeyAttribute(),
        );
    }

    // ? Getter Modules

    public function getCode(): ?string
    {
        return $this->{self::ATTRIBUTE_CODE};
    }

    public function getName(): ?string
    {
        return $this->{self::ATTRIBUTE_NAME};
    }

    public function getAccess(): ?array
    {
        return $this->{self::ATTRIBUTE_ACCESS};
    }

    public function getCreatedBy(): ?string
    {
        return $this->{self::ATTRIBUTE_CREATED_BY};
    }

    // ? Setter Modules

    public function setCode(string $code): self
    {
        $this->{self::ATTRIBUTE_CODE} = $code;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->{self::ATTRIBUTE_NAME} = $name;

        return $this;
    }

    public function setAccess(array $access): self
    {
        $this->{self::ATTRIBUTE_ACCESS} = $access;

        return $this;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->{self::ATTRIBUTE_CREATED_BY} = $createdBy;

        return $this;
    }
}
