<?php
namespace App\Models;

trait TranslatableTrait
{
    public function getLocale(): string
    {
        return app()->getLocale();
    }
}
