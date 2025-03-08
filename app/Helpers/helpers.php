<?php

use App\Enums\ConfigEnum;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Uri;

if (!function_exists('current_subdomain')) {
    function current_subdomain(): string
    {
        $host = request()->getHost();
        $parts = explode('.', $host);

        // Return the first part of the domain if available, otherwise return an empty string
        return count($parts) >= 2 ? $parts[0] : '';
    }
}

if (!function_exists('is_on_app')) {
    function is_on_app()
    {
        return str_starts_with(request()->path(), config('fortify.prefix'));
    }
}

if (!function_exists('is_admin_domain')) {
    function is_admin_domain()
    {
        return current_subdomain() === ConfigEnum::ADMIN_PREFIX->value;
    }
}

if (!function_exists('is_app_domain')) {
    function is_app_domain()
    {
        return current_subdomain() === ConfigEnum::APP_PREFIX->value;
    }
}

if (!function_exists('route_prefix')) {
    function route_prefix(): string
    {
        if (is_admin_domain()) {
            return ConfigEnum::ADMIN_PREFIX->value . ".";
        } else if (is_app_domain()) {
            return ConfigEnum::APP_PREFIX->value . ".";
        }

        return '';
    }
}

if (!function_exists('url_from_subdomain')) {
    function url_from_subdomain($subdomain): string
    {
        $uri = Uri::of(config('app.url'));
        return $uri->scheme() . rtrim($subdomain, '.') . '.' . $uri->host() . ':' . ($uri->port() ?? '8000');
    }
}

if (!function_exists('page_dir')) {
    function page_dir(): string
    {
        if (is_admin_domain()) {
            return ConfigEnum::ADMIN_PAGE_DIR->value . "/";
        } else if (is_app_domain()) {
            return ConfigEnum::APP_PAGE_DIR->value . "/";
        }

        return '';
    }
}

if (!function_exists('array_find')) {
    function array_find(array $array, callable $callback)
    {
        foreach ($array as $item) {
            if ($callback($item)) {
                return $item;
            }
        }
        return null; // Return null if no match is found
    }
}

if (!function_exists('filter_name')) {
    /**
     * Converts a class name or object into a filtered name.
     *
     * @param string|object $class The class name or object.
     * @return string The filtered name.
     */
    function filter_name(string|object $class): string
    {
        // Ensure $class is a string (class name)
        $className = is_object($class) ? get_class($class) : $class;

        // Map specific classes to their filtered names
        $classMap = [
            User::class => 'users',
            JobOffer::class => 'job_offers',
        ];

        // Return the mapped name if it exists, otherwise generate a kebab-case name
        return $classMap[$className] ?? Str::kebab(class_basename($className));
    }
}