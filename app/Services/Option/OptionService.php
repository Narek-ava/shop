<?php
namespace App\Services\Option;

use App\DTO\Option\CreateOptionDTO;
use App\Models\Attribute\Option\Option;
use App\Models\Attribute\Option\OptionTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class OptionService
 * @package App\Services\Option
 */
class OptionService
{
    /**
     * @param CreateOptionDTO $createOptionDTO
     * @return Option
     */
    public function create(CreateOptionDTO $createOptionDTO): Option
    {
        $option = new Option();
        $option->attribute_id = $createOptionDTO->attributeId;
        $option->save();

        foreach ($createOptionDTO->optionTranslationsDTO as $optionTranslationDTO) {
            $optionTranslation = new OptionTranslation();
            $optionTranslation->option_id = $option->id;
            $optionTranslation->locale = $optionTranslationDTO->locale;
            $optionTranslation->field = $optionTranslationDTO->field;
            $optionTranslation->value = $optionTranslationDTO->text;
            $optionTranslation->save();
        }

        return $option;
    }

    /**
     * @param int $attributeId
     * @param string $searchText
     * @param array $relations
     * @param int $limit
     * @return Collection
     */
    public function search(int | null $attributeId, string $searchText, array $relations = [], int $limit = 10): Collection
    {
        $options = Option::query();

        if ($attributeId){
            $options->where('attribute_id', $attributeId);
        }
        return $options->with($relations)->whereHas('translations', function (Builder $query) use ($searchText) {
            return $query->where('value', 'LIKE', "%$searchText%");
        })->limit($limit)->get();
    }

    /**
     * @param int $id
     * @return void
     * @throws ModelNotFoundException
     */
    public function delete(int $id): void
    {
        /**
         * @var Option $option
         */
        $option = Option::query()->findOrFail($id);
        $option->translations()->delete();
        $option->productVariants()->sync([]);
        $option->delete();
    }

    /**
     * @param int $id
     * @param array $relations
     * @return Option|Collection
     * @throws ModelNotFoundException
     */
    public function find(int $id, array $relations = []): Option|Collection
    {
        return Option::query()->with($relations)->findOrFail($id);
    }
}
