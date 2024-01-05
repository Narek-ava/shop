<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\Attribute\CreateAttributeDTO;
use App\DTO\Attribute\AttributeTranslationDTO;
use App\DTO\Attribute\UpdateAttributeDTO;
use App\DTO\Attribute\UpdateAttributeTranslationDTO;
use App\DTO\Category\UpdateCategoryDTO;
use App\DTO\Category\UpdateCategoryTranslationDTO;
use App\DTO\Pagination\PaginationFilterDTO;
use App\Enums\Locale\LocalesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Attribute\CreateRequest;
use App\Http\Requests\API\V1\Attribute\GetAttributeBYIdRequest;
use App\Http\Requests\API\V1\Attribute\SearchRequest;
use App\Http\Requests\API\V1\Attribute\UpdateAttributeRequest;
use App\Http\Requests\API\V1\Pagination\GetAllRequest;
use App\Http\Resources\V1\Attribute\AttributeResource;
use App\Managers\Attribute\AttributeManager;
use App\Models\Attribute\Attribute;
use App\Models\Category\Category;
use http\Env\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class AttributeController extends Controller
{
    private AttributeManager $attributeManager;

    /**
     * @param AttributeManager $attributeManager
     */
    public function __construct(AttributeManager $attributeManager)
    {
        $this->attributeManager = $attributeManager;
    }

    /**
     * @throws Throwable
     */
    public function createAction(CreateRequest $request)
    {
        $attributeTranslationsDTO = [];

        foreach ($request->getNameTranslations() as $locale => $text) {
            $attributeTranslationsDTO[] = new AttributeTranslationDTO(
                LocalesEnum::from($locale),
                'name',
                $text,
            );
        }

        $createAttributeDTO = new CreateAttributeDTO(
            $request->getIsFilterable(),
            $request->getPosition(),
            $attributeTranslationsDTO,
        );

        $attribute = $this->attributeManager->create($createAttributeDTO);

        return new AttributeResource($attribute);
    }

    /**
     * @param SearchRequest $request
     * @return AnonymousResourceCollection
     */
    public function searchAction(SearchRequest $request): AnonymousResourceCollection
    {
        return AttributeResource::collection($this->attributeManager->search($request->getSearchText(), ['nameTranslations']));
    }


    public function getById(GetAttributeBYIdRequest $request)
    {
        $attribute = $this->attributeManager->getById($request->getAttributeId());
        $attribute->load(['nameTranslations']);

        return  new AttributeResource($attribute);
    }

    /**
     * @param UpdateAttributeRequest $request
     * @return AttributeResource
     * @throws Throwable
     */
    public function update(UpdateAttributeRequest $request): AttributeResource
    {
        $updateAttributeTranslationDTO =[];
        if ($request->getNameTranslations() !== null) {
            foreach ($request->getNameTranslations() as $locale => $text) {
                $updateAttributeTranslationDTO[] =  new UpdateAttributeTranslationDTO(
                    LocalesEnum::from($locale),
                    Attribute::NAME_FIELD,
                    $text,
                    $request->getId(),
                );
            }
        }
        $updateAttributeDTO = new UpdateAttributeDTO(
            $request->getIsFilterable(),
            $request->getPosition(),
            $updateAttributeTranslationDTO,
            $request->getId()
        );

        $updateAttribute = $this->attributeManager->update($updateAttributeDTO);
        $updateAttribute->load('nameTranslations', 'nameTranslationRelation');

        return new AttributeResource($updateAttribute);
    }

    /**
     * @param GetAllRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetAllRequest $request): AnonymousResourceCollection
    {
        $getAllAttributeDTO = new PaginationFilterDTO(
            $request->getFilter(),
            $request->getPerPage(),
            $request->getCurrentPage(),
            []
        );

        $attributes = $this->attributeManager->getAll($getAllAttributeDTO);

        return AttributeResource::collection($attributes);
    }
}
