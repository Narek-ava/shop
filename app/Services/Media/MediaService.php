<?php

namespace App\Services\Media;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaService
{
public function deleteMediaById(int $id)
{
    try {
        $media = Media::findOrFail($id);
        $media->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }catch (\Exception $exception)
    {
        return response()->json(['message' => 'Image not founf'], 404);

    }
}
}
