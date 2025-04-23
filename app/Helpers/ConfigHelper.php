<?php

namespace App\Helpers;

use App\Enums\ConfigEnum;
use App\Enums\GenderEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ConfigHelper
{
    const ACTIVE_STATUSES = [
        ['label' => 'Actif', 'value' => 1],
        ['label' => 'Inactif', 'value' => 0],
    ];

    const PUBLISH_STATUSES = [
        ['label' => 'Publié', 'value' => 1],
        ['label' => 'Non Publié', 'value' => 0],
    ];

    const VALIDITY_STATUSES = [
        ['label' => 'Valide', 'value' => 1],
        ['label' => 'Expiré', 'value' => 0],
    ];

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
            'fortify_prefix' => config('fortify.prefix'),
            'is_gestion' => is_admin_domain(),
            'social_links' => social_links(),
            'seo' => seo(),
            'default_avatar' => asset('images/avatar/default.png'),
        ];
    }

    static public function getGenders(): array
    {
        $genders = [];
        foreach (GenderEnum::cases() as $gender) {
            $genders[] = $gender->value;
            $genders[] = Str::ucfirst($gender->value);
        }
        return array_unique($genders);
        return array_map(fn(GenderEnum $gender) => $gender->value, GenderEnum::cases());
    }
}
