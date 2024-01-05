<?php

namespace App\Http\Resources\V1\Option;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed $id
 * @property mixed $locale
 * @property mixed $category_id
 * @property mixed $field
 * @property mixed $value
 */
class OptionTranslationResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */
    #[ArrayShape([
        'locale' => "mixed",
        'value' => "mixed"
    ])]
    public function toArray(Request $request): array
    {
        return [
            'locale' => $this->locale,
            'value' => $this->value,
        ];
    }
}
