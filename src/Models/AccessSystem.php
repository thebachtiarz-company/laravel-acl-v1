<?php

namespace App\Libraries\MyACL\Models;

use App\Libraries\MyACL\Helpers\Models\AccessSystemModelHelper;
use App\Libraries\MyACL\Interfaces\Models\AccessSystemInterface;
use App\Libraries\MyACL\Models\Factory\AccessSystemFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use TheBachtiarz\Base\Models\AbstractModel;

class AccessSystem extends AbstractModel implements AccessSystemInterface
{
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        $this->setTable(self::TABLE_NAME);
        $this->fillable(self::ATTRIBUTE_FILLABLE);
        $this->mergeCasts([
            self::ATTRIBUTE_ACCESS => 'array',
        ]);

        $this->modelFactory = AccessSystemFactory::class;

        parent::__construct($attributes);
    }

    // ? Public Methods

    #[\Override]
    public function save(array $options = [])
    {
        if (!$this->getId()) {
            $this->{self::ATTRIBUTE_CODE} ??= AccessSystemModelHelper::generateCode();
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

    // ? Getter Modules

    public function getCode(): ?string
    {
        return $this->{self::ATTRIBUTE_CODE};
    }

    public function getAddress(): ?string
    {
        return $this->{self::ATTRIBUTE_ADDRESS};
    }

    public function getName(): ?string
    {
        return $this->{self::ATTRIBUTE_NAME};
    }

    public function getDescription(): ?string
    {
        return $this->{self::ATTRIBUTE_DESCRIPTION};
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

    public function setAddress(string $address): self
    {
        $this->{self::ATTRIBUTE_ADDRESS} = $address;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->{self::ATTRIBUTE_NAME} = $name;

        return $this;
    }

    public function setDescription(?string $description = null): self
    {
        $this->{self::ATTRIBUTE_DESCRIPTION} = $description;

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
