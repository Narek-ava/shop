<?php
namespace App\Services\Brand;

use App\DTO\Brand\CreateBrandDTO;
use App\DTO\Brand\UpdateBrandDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Http\Requests\API\V1\Brand\SearchBrandRequest;
use App\Models\Brand\Brand;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ZipStream\Test\DataDescriptorTest;

/**
 * Class BrandService
 * @package App\Services\Brand
 */
class BrandService
{
    /**
     * @param CreateBrandDTO $createBrandDTO
     * @return Brand
     */
    public function create(CreateBrandDTO $createBrandDTO): Brand
    {
        $brand = new Brand();
        $brand->slug = $createBrandDTO->slug;
        $brand->name = $createBrandDTO->name;
        $brand->position = $createBrandDTO->position;
        $brand->save();
        $brand->addMedia($createBrandDTO->image)->toMediaCollection('images');

        return $brand;
    }

    /**
     * @param $searchText
     * @return Collection|array
     */
    public function search($searchText): Collection|array
    {
        $searchText = str_split($searchText);
        $query = Brand::query();
        foreach ($searchText as $letter) {
            $query->orWhere("name", "LIKE", "%" . $letter . "%");
        }

        return $query->get();
    }

    public function updateAction(UpdateBrandDTO $updateBrandDTO): Model
    {
        $brand =Brand::query()->where('id', $updateBrandDTO->brandId)->first();
        $brand->slug = $updateBrandDTO->slug;
        $brand->name = $updateBrandDTO->name;
        $brand->position = $updateBrandDTO->position;
        $brand->save();
        if ($updateBrandDTO->image && $brand->getFirstMedia()){
            $brand->setNewMedia($updateBrandDTO->image)->toMediaCollection('images');
        }
        return $brand;
    }

    /**
     * @param int $id
     * @param array $relations
     * @return Brand|Collection
     * @throws ModelNotFoundException
     */
    public function find(int $id, array $relations =[ ]): Brand|Collection
    {
        return Brand::query()->with($relations)->findOrFail($id);
    }

    /**
     * @param int $limit
     * @param array $relations
     * @return Collection|array
     */
    public function getPopular(int $limit, array $relations = []): Collection|array
    {
        $query = Brand::query()
            ->with($relations)
            ->selectRaw('COUNT(products.id) as product_count, brands.id as id, brands.slug, brands.created_at, brands.name, brands.position')
            ->leftJoin('products', 'products.brand_id', '=', 'brands.id')
            ->groupBy('brands.id', 'brands.slug', 'brands.created_at')
            ->orderByDesc('product_count');

        return $query->limit($limit)->get();
    }


    /**
     * @param PaginationFilterDTO $paginationFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $paginationFilterDTO): LengthAwarePaginator
    {
        return Brand::query()->with($paginationFilterDTO->relations)->paginate($paginationFilterDTO->perPage, ['*'], 'page', $paginationFilterDTO->page);
    }
}
