<?php

use App\Enums\ConfigEnum;
use App\Models\JobOffer;
use App\Models\Setting;
use App\Models\SocialLink;
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

if (!function_exists('settings')) {
    function settings($key = null)
    {
        $setting = Setting::first() ?? new Setting();

        if ($key) {
            try {
                return $setting->$key;
            } catch (\Throwable $th) {
                return "";
            }
        }

        $setting->makeHidden(['contact_url', 'tcs_url']);

        return $setting;
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

if (!function_exists('seo')) {
    function seo($key = null)
    {
        $data = [
            'description' => settings()->site_description ?? config('app.name') . " c'est le lieu où l'avenir prend forme pour les jeunes. Viens t'engager et t'exprimer pour ton avenir !",
            'keywords' => settings()->site_keywords ? implode(',', settings()->site_keywords) : [config('app.name'), "Agora des jeunes", "Adiza Arouna", "Arouna Adizatou"],
            "og_title" => config('app.name') . " : Exprimes toi, engages toi... C'est ici que l'avenir prend forme.",
            'slogan' => settings()->site_slogan ?? "Agora, le lieu où l'avenir prend forme !",
        ];

        if ($key) {
            try {
                return $data[$key];
            } catch (\Throwable $th) {
                return "";
            }
        }

        return $data;
    }
}

if (!function_exists('social_links')) {
    function social_links($key = null)
    {
        $links = SocialLink::class;

        if ($key) {
            return $links::where('platform', $key)->first();
        }

        return $links::all();
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

if (!function_exists('reg_url')) {
    function reg_url($token = null): String
    {
        return config('app.url') . '/' . config('fortify.prefix') . '/register' . ($token ? '?token=' . $token : '');
    }
}

if (!function_exists('no_image')) {
    function no_image()
    {
        return asset('images/no-image.jpeg');
    }
}
