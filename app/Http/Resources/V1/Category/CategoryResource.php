<?php

namespace App\Http\Resources\V1\Category;

use App\Models\Category\Category;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class CategoryResource
 * @package App\Http\Resources\V1\Category
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $created_at
 * @property int $parent_id
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'id' => "int",
        'slug' => "string",
        'name' =>"string",
        'created_at' => "string",
        'subcategories' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection",
        'nameTranslations' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection",
        'parentCategoryId'=> "int"
    ])]

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'subcategories' => CategoryResource::collection($this->whenLoaded('subcategories')),
            'nameTranslations' => CategoryTranslationResource::collection($this->whenLoaded('nameTranslations')),
            'parentCategoryId' => $this->parent_id
        ];
    }
}

