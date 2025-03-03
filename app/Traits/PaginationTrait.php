<?php

namespace App\Traits;

trait PaginationTrait
{
    public static function perPage($default = 20): int
    {
        $default = $default ?? 20;
        return request()->get('per_page', $default);
    }
}
