<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\Option\OptionTranslationDTO;
use App\DTO\Option\CreateOptionDTO;
use App\Enums\Locale\LocalesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Option\CreateRequest;
use App\Http\Requests\API\V1\Option\DeleteOptionRequest;
use App\Http\Requests\API\V1\Option\FindRequest;
use App\Http\Requests\API\V1\Option\SearchRequest;
use App\Http\Resources\V1\Option\OptionResource;
use App\Managers\Option\OptionManager;
use App\Models\Attribute\Option\Option;
use App\Models\Attribute\Option\OptionTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class OptionController extends Controller
{
    private OptionManager $optionManager;

    /**
     * @param OptionManager $optionManager
     */
    public function __construct(OptionManager $optionManager)
    {
        $this->optionManager = $optionManager;
    }

    /**
     * @param CreateRequest $request
     * @return OptionResource
     * @throws Throwable
     */
    public function createAction(CreateRequest $request): OptionResource
    {
        $optionTranslationsDTO = [];

        foreach ($request->getNameTranslations() as $locale => $text) {
            $optionTranslationsDTO[] = new OptionTranslationDTO(
                LocalesEnum::from($locale),
                'name',
                $text,
            );
        }

        $createOptionDTO = new CreateOptionDTO(
            $request->getAttributeId(),
            $optionTranslationsDTO,
        );

        $option = $this->optionManager->create($createOptionDTO);

        return new OptionResource($option);
    }

    /**
     * @param SearchRequest $request
     * @return AnonymousResourceCollection
     */
    public function searchAction(SearchRequest $request): AnonymousResourceCollection
    {
        return OptionResource::collection($this->optionManager->search($request->getAttributeId(),$request->getSearchText(), ['nameTranslations'], 10));
    }

    /**
     * @throws Throwable
     */
    public function deleteAction(DeleteOptionRequest $request): JsonResponse
    {
        $this->optionManager->delete($request->getId());

        return response()->json('ok');
    }

    /**
     * @param FindRequest $request
     * @return OptionResource
     */
    public function findAction(FindRequest $request): OptionResource
    {
        return new OptionResource($this->optionManager->find($request->getId(), ['nameTranslations']));
    }
}
