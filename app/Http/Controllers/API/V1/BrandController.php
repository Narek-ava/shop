<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\Brand\CreateBrandDTO;
use App\DTO\Brand\UpdateBrandDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Brand\CreateRequest;
use App\Http\Requests\API\V1\Brand\FindRequest;
use App\Http\Requests\API\V1\Brand\SearchBrandRequest;
use App\Http\Requests\API\V1\Brand\UpdateBrandRequest;
use App\Http\Requests\API\V1\Category\GetPopularRequest;
use App\Http\Requests\API\V1\Pagination\GetAllRequest;
use App\Http\Requests\Media\DeleteMediaByIdRequest;
use App\Http\Resources\V1\Brand\BrandResource;
use App\Http\Resources\V1\Category\CategoryResource;
use App\Managers\Brand\BrandManager;
use App\Models\Brand\Brand;
use App\Services\Media\MediaService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

class BrandController extends Controller
{
    private BrandManager $brandManager;
    private MediaService $mediaService;

    /**
     * @param BrandManager $brandManager
     * @param MediaService $mediaService
     */
    public function __construct(
        BrandManager $brandManager,
        MediaService $mediaService,
    )
    {
        $this->mediaService = $mediaService;
        $this->brandManager = $brandManager;
    }

    /**
     * @param CreateRequest $request
     * @return BrandResource
     * @throws Throwable
     */
    public function createAction(CreateRequest $request): BrandResource
    {
        $createBrandDTO = new CreateBrandDTO(
            $request->getSlug(),
            $request->getName(),
            $request->getPosition(),
            $request->getImage(),
        );

        $brand = $this->brandManager->create($createBrandDTO);
        $brand->load(['image']);

        return new BrandResource($brand);
    }

    /**
     * @param SearchBrandRequest $request
     * @return Collection|array
     */
    public function searchAction(SearchBrandRequest $request): Collection|array
    {
        return $this->brandManager->search($request->getSearchText());
    }

    /**
     * @param FindRequest $request
     * @return BrandResource
     * @throws ModelNotFoundException
     */
    public function findAction(FindRequest $request): BrandResource
    {
        $brand = $this->brandManager->find($request->getId());
        $brand->load([ 'image']);

        return new BrandResource($this->brandManager->find($request->getId()));
    }

    public function updateAction(UpdateBrandRequest $request): BrandResource
    {
        $updateBrandDTO = new  UpdateBrandDTO(
            $request->getId(),
            $request->getSlug(),
            $request->getName(),
            $request->getPosition(),
            $request->getImage()
        );

        $brand = $this->brandManager->updateAction($updateBrandDTO);
        $brand->load(['image']);

        return new BrandResource($brand);
    }

    /**
     * @param DeleteMediaByIdRequest $request
     * @return JsonResponse
     */
    public function deleteImage(DeleteMediaByIdRequest $request): JsonResponse
    {
        return $this->mediaService->deleteMediaById($request->getId());
    }

    /**
     * @param GetPopularRequest $request
     * @return AnonymousResourceCollection
     */
    public function getPopularAction(GetPopularRequest $request): AnonymousResourceCollection
    {
        return BrandResource::collection($this->brandManager->getPopular($request->getLimit() ?: 10));
    }

    /**
     * @param GetAllRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetAllRequest $request): AnonymousResourceCollection
    {
        $getAllBrandsDTO = new PaginationFilterDTO(
            $request->getFilter(),
            $request->getPerPage(),
            $request->getCurrentPage(),
            ['image']
        );

        $brands = $this->brandManager->getAll($getAllBrandsDTO);

        return BrandResource::collection($brands);
    }
}
