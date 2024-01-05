<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\Category\CategoryTranslationDTO;
use App\DTO\Category\CreateCategoryDTO;
use App\DTO\Category\UpdateCategoryDTO;
use App\DTO\Category\UpdateCategoryTranslationDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Enums\Locale\LocalesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Category\CreateRequest;
use App\Http\Requests\API\V1\Category\GetCategoryTreeRequest;
use App\Http\Requests\API\V1\Category\GetPopularRequest;
use App\Http\Requests\API\V1\Category\GetRequest;
use App\Http\Requests\API\V1\Category\GetSearchTextRequest;
use App\Http\Requests\API\V1\Category\UpdateRequest;
use App\Http\Requests\API\V1\Pagination\GetAllRequest;
use App\Http\Resources\V1\Category\CategoryResource;
use App\Managers\Category\CategoryManager;
use App\Models\Category\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

/**
 * Class CategoryController
 * @package App\Http\Controllers\API\V1
 * @property CategoryManager $categoryManager
 * @method CategoryManager getCategoryManager()
 */
class CategoryController extends Controller
{
    private CategoryManager $categoryManager;

    /**
     * @param CategoryManager $categoryManager
     */
    public function __construct(CategoryManager $categoryManager)
    {
        $this->categoryManager = $categoryManager;
    }

    /**
     * @param CreateRequest $request
     * @return CategoryResource
     * @throws Throwable
     */
    public function createAction(CreateRequest $request): CategoryResource
    {
        $categoryTranslationsDTO = [];

        foreach ($request->getNameTranslations() as $locale => $text) {
            $categoryTranslationsDTO[] = new CategoryTranslationDTO(
                LocalesEnum::from($locale),
                'name',
                $text,
            );
        }

        $categoryDto = new CreateCategoryDTO(
            $request->getSlug(),
            $categoryTranslationsDTO,
            $request->getParentId(),
        );

        $category = $this->categoryManager->create($categoryDto);
        $category->load('nameTranslations');

        return new CategoryResource($category);
    }

    /**
     * @param GetCategoryTreeRequest $request
     * @return AnonymousResourceCollection
     */
    public function getCategoryTree(GetCategoryTreeRequest $request): AnonymousResourceCollection
    {
        return CategoryResource::collection($this->categoryManager->getTreeWithSubcategories($request->getCategoryIds()));
    }

    /**
     * @param GetRequest $request
     * @return CategoryResource
     */
    public function findAction(GetRequest $request): CategoryResource
    {
        return new CategoryResource($this->categoryManager->find($request->getId(), ['nameTranslations']));
    }

    /**
     * @param GetSearchTextRequest $request
     * @return AnonymousResourceCollection
     */
    public function searchAction(GetSearchTextRequest $request): AnonymousResourceCollection
    {
        $searchResult = $this->categoryManager
            ->search($request->getSearchText(), ['nameTranslations'], $request->getLimit() ?: 10);

        return CategoryResource::collection($searchResult);
    }

    /**
     * @param GetPopularRequest $request
     * @return AnonymousResourceCollection
     */
    public function getPopularAction(GetPopularRequest $request): AnonymousResourceCollection
    {
        return CategoryResource::collection($this->categoryManager->getPopular($request->getLimit() ?: 10));
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request): CategoryResource
    {
        $updateCategoryTranslationsDTO = [];

        if ($request->getNameTranslations() !== null) {
            foreach ($request->getNameTranslations() as $locale => $text) {
                $updateCategoryTranslationsDTO[] = new UpdateCategoryTranslationDTO(
                    LocalesEnum::from($locale),
                    Category::NAME_FIELD,
                    $text,
                    $request->getId(),
                );
            }
        }

        $updateCategoryDTO = new UpdateCategoryDTO(
            $request->getSlug(),
            $updateCategoryTranslationsDTO,
            $request->getParentId(),
            $request->getId(),
        );

        $updatedCategory = $this->categoryManager->update($updateCategoryDTO);
        $updatedCategory->load('nameTranslations', 'nameTranslationRelation');

        return new CategoryResource($updatedCategory);
    }


    /**
     * @param GetAllRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetAllRequest $request): AnonymousResourceCollection
    {
        $getAllCategoriesDTO = new PaginationFilterDTO(
            $request->getFilter(),
            $request->getPerPage(),
            $request->getCurrentPage(),
            ['nameTranslations']
        );
        $categories = $this->categoryManager->getAll($getAllCategoriesDTO);

        return CategoryResource::collection($categories);
    }

}
