<?php

namespace App\Traits;

trait FilterTrait
{
    use PaginationTrait;

    public static function getFilter($type, string $key = "", $default = null)
    {
        try {
            $filterName = filter_name($type);
            $filters = session()->get("filters.{$filterName}", []);

            if ($key && key_exists($key, $filters)) {
                return $filters[$key];
            } else if ($key == 'per_page') {
                return self::perPage($default);
            } else {
                throw new \Exception("Le filtre {$key} n'existe pas dans les filtres de {$type}.");
            }

            return $filters;
        } catch (\Throwable $th) {
            if ($key) {
                return null;
            }

            return [];
        }
    }
}
