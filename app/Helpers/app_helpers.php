<?php

use App\Enums\ConfigEnum;
use App\Models\JobOffer;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Uri;

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
