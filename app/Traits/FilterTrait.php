<?php

namespace App\Traits;

trait FilterTrait
{
    use PaginationTrait;

    public static function getFilter($type, string $key = "", $default = null): array|string|null
    {
        try {
            $filterName = filter_name($type); // Ensure this helper exists and works
            $filters = session()->get("filters.{$filterName}", []);

            if ($key === 'per_page') {
                // Handle pagination specifically
                return self::perPage($default);
            } else if ($key !== "") {
                // Key provided: return value if exists, otherwise default
                return array_key_exists($key, $filters) ? ($filters[$key] ?? $default) : $default;
            }

            // No key provided, return all filters
            return $filters;
        } catch (\Throwable $th) {
            // General fallback in case of unexpected errors (e.g., session issues)
            // report($th); // Optional: Log the error
            return $key ? null : []; // Return null if specific key asked, else empty array
        }
    }
}
