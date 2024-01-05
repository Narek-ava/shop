<?php
namespace App\Services\Category;

use App\DTO\Category\CreateCategoryDTO;
use App\DTO\Category\UpdateCategoryDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Models\Category\Category;
use App\Models\Category\CategoryTranslation;
use App\Models\Product\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\b;

/**
 * Class CategoryService
 * @package App\Services\Category
 */
class CategoryService
{
    /**
     * @param CreateCategoryDTO $createCategoryDTO
     * @return Category
     */
    public function create(CreateCategoryDTO $createCategoryDTO): Category
    {
        $category = new Category();
        $category->slug = $createCategoryDTO->slug;
        $category->parent_id = $createCategoryDTO->parentId;
        $category->save();

        foreach ($createCategoryDTO->categoryTranslationsDTO as $categoryTranslationDTO) {
            $categoryTranslation = new CategoryTranslation();
            $categoryTranslation->category_id = $category->id;
            $categoryTranslation->locale = $categoryTranslationDTO->locale;
            $categoryTranslation->field = $categoryTranslationDTO->field;
            $categoryTranslation->value = $categoryTranslationDTO->text;
            $categoryTranslation->save();
        }

        return $category;
    }

    /**
     * @return Collection|Category[]
     */
    public function getTreeWithSubcategories(array $categoryIds): Collection|array
    {
        $query = Category::query()->with(['subcategories']);

        if (!empty($categoryIds)) {
            $query->whereIn('id', $categoryIds);
        } else {
            $query->whereNull('parent_id');
        }

        return $query->get();
    }

    /**
     * @param UpdateCategoryDTO $updateCategoryDTO
     * @return Builder|Model
     */
    public function update(UpdateCategoryDTO $updateCategoryDTO): Builder|Model
    {
        $updateCategory = new Category();
        $updateCategory = $updateCategory->query()
            ->where('id', $updateCategoryDTO->categoryId)->first();
        $updateCategory->slug = $updateCategoryDTO->slug;
        $updateCategory->parent_id = $updateCategoryDTO->parentId;
        $updateCategory->save();

        foreach ($updateCategoryDTO->translations as $translations) {

            CategoryTranslation::query()->where('id', $updateCategoryDTO->categoryId)->first()
                ->updateOrCreate([
                    'category_id' => $translations->categoryId,
                    'field' => $translations->field,
                    'locale' => $translations->locale->toString()
                ], [
                    'value' => $translations->text
                ]);
        }
        return $updateCategory;
    }

    /**
     * @param string|null $searchText
     * @param array $relations
     * @param int $limit
     * @return Collection|array
     */
    public function search(string|null $searchText, array $relations = [], int $limit = 10): Collection|array
    {
        $query = Category::query()->with($relations)->whereHas('nameTranslations', function (Builder $query) use ($searchText) {
            $query->where('value', 'LIKE', '%' . $searchText . '%');
        });

        return $query->limit($limit)->get();
    }

    public function getPopular(int $limit, array $relations = []): Collection|array
    {
        $query = Category::query()
            ->with($relations)
            ->selectRaw('COUNT(*) as product_count, categories.id as id, categories.slug, categories.created_at')
            ->leftJoin('products', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.id')
            ->orderByDesc('product_count');

        return $query->limit($limit)->get();
    }

    /**
     * @param $id
     * @param array $relations
     * @return Builder|Collection|Category
     */
    public function find($id, array $relations = []): Builder|Collection|Category
    {
        return Category::query()->with($relations)->findOrFail($id);
    }

    /**
     * @param PaginationFilterDTO $paginationFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $paginationFilterDTO): LengthAwarePaginator
    {
        return Category::query()->with($paginationFilterDTO->relations)->paginate($paginationFilterDTO->perPage, ['*'], 'page', $paginationFilterDTO->page);
    }
}
