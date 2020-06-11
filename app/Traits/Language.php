<?php

namespace App\Traits;

trait Language
{

    public $localization = 'fa';

    public function translate($slug)
    {
        return config("language.{$this->localization}.{$slug}");
    }
}