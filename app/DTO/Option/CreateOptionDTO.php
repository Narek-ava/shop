<?php
namespace App\DTO\Option;

use App\DTO\DTO;
/**
 * Class CreateOptionDTO
 * @package App\DTO\Option
 * @property int $attributeId
 * @property OptionTranslationDTO[] $optionTranslationsDTO
 */
class CreateOptionDTO implements DTO
{
    public int $attributeId;

    /**
     * @var OptionTranslationDTO[]
     */
    public array $optionTranslationsDTO;

    /**
     * CreateOptionDTO constructor.
     *
     * @param int $attributeId
     * @param OptionTranslationDTO[] $optionTranslationsDTO
     */
    public function __construct(
        int $attributeId,
        array $optionTranslationsDTO,
    ) {
        $this->attributeId = $attributeId;
        $this->optionTranslationsDTO = $optionTranslationsDTO;
    }
}
