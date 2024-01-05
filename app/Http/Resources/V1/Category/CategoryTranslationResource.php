<?php

namespace App\Http\Resources\V1\Category;

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
class CategoryTranslationResource extends JsonResource
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
