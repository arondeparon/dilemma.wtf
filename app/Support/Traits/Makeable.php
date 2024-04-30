<?php

namespace App\Support\Traits;

trait Makeable
{
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }
}
