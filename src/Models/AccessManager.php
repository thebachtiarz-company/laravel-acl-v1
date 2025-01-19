<?php

namespace TheBachtiarz\ACL\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TheBachtiarz\ACL\Helpers\Models\AccessManagerModelHelper;
use TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;
use TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
use TheBachtiarz\ACL\Models\Factory\AccessManagerFactory;
use TheBachtiarz\Base\Models\AbstractModel;

class AccessManager extends AbstractModel implements AccessManagerInterface
{
    public function __construct(array $attributes = [])
    {
        $this->setTable(self::TABLE_NAME);
        $this->fillable(self::ATTRIBUTE_FILLABLE);
        $this->mergeCasts([
            self::ATTRIBUTE_ACCESS => 'array',
        ]);

        $this->modelFactory = AccessManagerFactory::class;

        parent::__construct($attributes);
    }

    // ? Public Methods

    #[\Override]
    public function save(array $options = [])
    {
        if (!$this->getId()) {
            $this->{self::ATTRIBUTE_CODE} ??= AccessManagerModelHelper::generateCode();
        }

        return parent::save(options: $options);
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Maps

    public function simpleListMap(array $attributes = [], array $hides = []): array
    {
        $map = [
            'source' => $this->sourceAccess()->get()->first()->getName(),
        ];

        foreach ($map as $key => $value) {
            $this->setData(attribute: $key, value: $value);
        }

        $attributes = array_unique(array_merge($attributes, array_keys($map)));

        $hides = array_unique(array_merge($hides, [
            self::ATTRIBUTE_SOURCE_ACCESS_ID,
        ]));

        return parent::simpleListMap($attributes, $hides);
    }

    // ? Relation

    public function sourceAccess(): BelongsTo
    {
        return $this->belongsTo(
            related: SourceAccess::class,
            foreignKey: self::ATTRIBUTE_SOURCE_ACCESS_ID,
            ownerKey: app(SourceAccessInterface::class)->getPrimaryKeyAttribute(),
        );
    }

    // ? Getter Modules

    public function getSourceAccessId(): ?int
    {
        return $this->{self::ATTRIBUTE_SOURCE_ACCESS_ID};
    }

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

    public function setSourceAccessId(int $sourceAccessId): self
    {
        $this->{self::ATTRIBUTE_SOURCE_ACCESS_ID} = $sourceAccessId;

        return $this;
    }

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
