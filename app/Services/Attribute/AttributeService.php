<?php
namespace App\Services\Attribute;

use App\DTO\Attribute\CreateAttributeDTO;
use App\DTO\Attribute\UpdateAttributeDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Http\Resources\V1\Attribute\AttributeResource;
use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeTranslation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class AttributeService
 * @package App\Services\Attribute
 */
class AttributeService
{
    /**
     * @param CreateAttributeDTO $createAttributeDTO
     * @return Attribute
     */
    public function create(CreateAttributeDTO $createAttributeDTO): Attribute
    {
        $attribute = new Attribute();
        $attribute->is_filterable = $createAttributeDTO->isFilterable;
        $attribute->position = $createAttributeDTO->position;
        $attribute->save();

        foreach ($createAttributeDTO->attributeTranslationsDTO as $attributeTranslationDTO) {
            $attributeTranslation = new AttributeTranslation();
            $attributeTranslation->attribute_id = $attribute->id;
            $attributeTranslation->locale = $attributeTranslationDTO->locale;
            $attributeTranslation->field = $attributeTranslationDTO->field;
            $attributeTranslation->value = $attributeTranslationDTO->text;
            $attributeTranslation->save();
        }

        return $attribute;
    }

    /**attribute_id
     * @param string $searchText
     * @param int $limit
     * @param array $relations
     * @return Collection
     */
    public function search(string $searchText, array $relations = [], int $limit = 10): Collection
    {
        return Attribute::query()->with($relations)->whereHas('translations', function (Builder $query) use ($searchText) {
            return $query->where('value', 'LIKE', "%$searchText%");
        })->limit($limit)->get();
    }

    public function update(UpdateAttributeDTO $updateAttributeDTO)
    {
        $updateAttribute = new Attribute();
        $updateAttribute = $updateAttribute->query()
            ->where('id', $updateAttributeDTO->attributeId)->first();
        $updateAttribute->is_filterable = $updateAttributeDTO->isFilterable;
        $updateAttribute->position = $updateAttributeDTO->position;
        $updateAttribute->save();

        foreach ($updateAttributeDTO->nameTranslation as  $translations) {
            AttributeTranslation::query()->where('attribute_id', $updateAttributeDTO->attributeId)->first()
                ->updateOrCreate([
                    'attribute_id' => $translations->attributeId,
                    'field' => $translations->field,
                    'locale' => $translations->locale->toString()
                ], [
                    'value' => $translations->text
                ]);
        }
        return $updateAttribute;
    }

    /**
     * @param PaginationFilterDTO $paginationFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $paginationFilterDTO): LengthAwarePaginator
    {
        return Attribute::query()->with($paginationFilterDTO->relations)->paginate($paginationFilterDTO->perPage, ['*'], 'page', $paginationFilterDTO->page);
    }
}
