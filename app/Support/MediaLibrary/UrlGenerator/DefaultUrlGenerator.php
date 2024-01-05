<?php

namespace App\Support\MediaLibrary\UrlGenerator;

class DefaultUrlGenerator extends \Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator
{
    public function getUrl(): string
    {
        $url = (in_array($this->media->getDiskDriverName(), ['s3', 'minio']))
            ? $this->getDisk()->temporaryUrl($this->getPathRelativeToRoot(), now()->addMinutes(15))
            : $this->getDisk()->url($this->getPathRelativeToRoot());

        $url = $this->versionUrl($url);

        return $url;
    }
}
