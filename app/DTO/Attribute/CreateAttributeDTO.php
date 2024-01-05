<?php
namespace App\DTO\Attribute;

use App\DTO\DTO;
/**
 * Class CreateAttributeDTO
 * @package App\DTO\Attribute
 * @property bool $isFilterable
 * @property int $position
 * @property AttributeTranslationDTO[] $attributeTranslationsDTO
 */
class CreateAttributeDTO implements DTO
{
    public bool $isFilterable;
    public int $position;

    /**
     * @var AttributeTranslationDTO[]
     */
    public array $attributeTranslationsDTO;

    /**
     * CreateAttributeDTO constructor.
     *
     * @param bool $isFilterable
     * @param int $position
     * @param AttributeTranslationDTO[] $attributeTranslationsDTO
     */
    public function __construct(
        bool $isFilterable,
        int $position,
        array $attributeTranslationsDTO,
    ) {
        $this->isFilterable = $isFilterable;
        $this->position = $position;
        $this->attributeTranslationsDTO = $attributeTranslationsDTO;
    }
}
