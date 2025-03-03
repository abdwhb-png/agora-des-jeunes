<?php

namespace App\Helpers;

use App\Enums\ConfigEnum;
use Illuminate\Support\Arr;

class ConfigHelper
{
    static public function imageRules($maxSize = null): array
    {
        $maxSize = $maxSize ?? (int) ConfigEnum::IMG_MAX_FILE_SIZE->value;
        return [
            'image',
            'mimes:jpeg,png,jpg,heic',
            'max:' . $maxSize,
        ];
    }

    static public function getConfig(): array
    {
        return [
            ...Arr::only(settings()->toArray(), ['site_email', 'site_phone', 'site_address']),
            'social_links' => social_links(),
            'seo' => seo(),
            'default_avatar' => asset('images/avatar/default.png'),
        ];
    }
}