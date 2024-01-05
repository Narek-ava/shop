<?php
namespace App\DTO\Product;

use App\DTO\DTO;
/**
 * Class CreateProductDTO
 * @package App\DTO\Product
 * @property int $brandId
 * @property int $categoryId
 * @property int $position
 * @property bool $published
 * @property ProductTranslationDTO[] $productTranslationsDTO
 */
class CreateProductDTO implements DTO
{
    public int $categoryId;
    public int $position;
    public bool $published;
    public int $brandId;

    /**
     * @var ProductTranslationDTO[]
     */
    public array $productTranslationsDTO;

    /**
     * @param int $categoryId
     * @param int $position
     * @param bool $published
     * @param ProductTranslationDTO[] $productTranslationsDTO
     * @param int $brandId
     */
    public function __construct(
        int $categoryId,
        int $position,
        bool $published,
        array $productTranslationsDTO,
        int $brandId,
    ) {
        $this->categoryId = $categoryId;
        $this->position = $position;
        $this->published = $published;
        $this->productTranslationsDTO = $productTranslationsDTO;
        $this->brandId = $brandId;
    }
}
