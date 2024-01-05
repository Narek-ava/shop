<?php

namespace App\DTO\Category;

use App\DTO\DTO;
/**
 * Class CreateCategoryDTO
 * @package App\DTO\Category
 * @property string $slug
 * @property CategoryTranslationDTO[] $categoryTranslationsDTO
 * @property int|null $parentId
 */
class CreateCategoryDTO implements DTO
{
    public string $slug;
    /**
     * @var CategoryTranslationDTO[]
     */
    public array $categoryTranslationsDTO;
    public ?int $parentId;

    /**
     * @param string $slug
     * @param CategoryTranslationDTO[] $categoryTranslationsDTO
     * @param int|null $parentId
     */
    public function __construct(
        string $slug,
        array $categoryTranslationsDTO,
        ?int $parentId = null,
    ) {
        $this->slug = $slug;
        $this->parentId = $parentId;
        $this->categoryTranslationsDTO = $categoryTranslationsDTO;
    }
}
