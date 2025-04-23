<?php

use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

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

if (!function_exists('seo')) {
    function seo($key = null)
    {
        $data = [
            "title" => config('app.name') . " - Autonomisation et Opportunités pour la Jeunesse",
            'description' => settings()->site_description ?? config('app.name') . " la plateforme qui t’accompagne dans ton éducation, ton développement personnel et ton avenir professionnel. Rejoins " . config('app.name') . " pour accéder à des formations, offres d’emploi, bourses et outils pour réussir ton avenir !",
            'keywords' => implode(',', settings('site_keywords') ? settings('site_keywords') : [config('app.name')]),
            'slogan' => settings()->site_slogan ?? config('app.name') . ", le lieu où l'avenir prend forme !",
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

if (!function_exists('is_date')) {
    function is_date($param): String
    {
        $factory = new ValidationFactory();

        return !$factory->make(
            ['date' => $param],
            ['date' => 'date']
        )->fails();
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
