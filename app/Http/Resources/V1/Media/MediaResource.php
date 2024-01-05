<?php

namespace App\Http\Resources\V1\Media;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property Media $resource
 * @property int $id
 *
 */
class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'mediaId' => $this->id,
            'url' => $this->resource->getFullUrl(),
            'preview'=> $this->resource->getFullUrl('preview')
        ];
    }
}
