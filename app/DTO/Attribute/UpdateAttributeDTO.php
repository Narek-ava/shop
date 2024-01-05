<?php

namespace App\DTO\Attribute;

use App\DTO\DTO;
use App\Enums\Locale\LocalesEnum;

class UpdateAttributeDTO implements DTO
{
    /**
     * @var bool
     */
    public bool $isFilterable;
    /**
     * @var int
     */
    public int $position;
    /**
     * @var array|null
     */
    public ?array $nameTranslation;
    /**
     * @var int
     */
    public int $attributeId;

    public function __construct(
        bool $isFilterable,
        int $position,
        array | null $nameTranslation,
        int $attributeId
    )
    {
         $this->isFilterable = $isFilterable;
         $this->position = $position;
         $this->nameTranslation =$nameTranslation;
         $this->attributeId = $attributeId;
    }
}
