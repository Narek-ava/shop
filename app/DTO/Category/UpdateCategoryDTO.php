<?php

namespace App\DTO\Category;

use App\DTO\DTO;

/**
 * @property $translations
 */
class UpdateCategoryDTO extends CreateCategoryDTO implements DTO
{
    public string $slug;
    public array $translations;
    public ?int $parentId;
    public int $categoryId;

    /**
     * @param string $slug
     * @param array $translations
     * @param int|null $parentId
     * @param int $categoryId
     */
    public function __construct(
        string $slug,
        array  $translations,
        ?int   $parentId,
        int    $categoryId,
    )
    {
        $this->slug = $slug;
        $this->translations = $translations;
        $this->parentId = $parentId;
        $this->categoryId = $categoryId;
    }
}
