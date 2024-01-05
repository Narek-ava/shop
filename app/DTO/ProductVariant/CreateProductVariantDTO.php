<?php
namespace App\DTO\ProductVariant;

use App\DTO\DTO;
/**
 * Class CreateProductVariantDTO
 * @package App\DTO\ProductVariant
 * @property bool $published
 * @property ProductVariantTranslationDTO[] $productVariantTranslationsDTO
 */
class CreateProductVariantDTO implements DTO
{
    public int $productId;
    public string $sku;
    public bool $published;
    public int $position;
    public int $price;
    public array | null $images;

    /**
     * @var ProductVariantTranslationDTO[]
     */
    public array $productVariantTranslationsDTO;

    public function __construct(
        int $productId,
        string $sku,
        bool $published,
        int $position,
        int $price,
        array $productVariantTranslationsDTO,
        array | null $images
    ) {
        $this->productId = $productId;
        $this->sku = $sku;
        $this->published = $published;
        $this->position = $position;
        $this->price = $price;
        $this->productVariantTranslationsDTO = $productVariantTranslationsDTO;
        $this->images = $images;
    }
}
