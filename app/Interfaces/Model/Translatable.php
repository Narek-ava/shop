<?php

namespace App\Interfaces\Model;

interface Translatable
{
    /**
     * @return array
     */
    public static function getTranslatableFields(): array;

    /**
     * @return string
     */
    public function getLocale(): string;
}
