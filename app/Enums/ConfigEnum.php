<?php

namespace App\Enums;

enum ConfigEnum: string
{
    case ADMIN_PREFIX = 'gestion';
    case APP_PREFIX = 'app';

    case ADMIN_PAGE_DIR = 'Gestion';
    case APP_PAGE_DIR = 'App';

    case ENFORCE_DOMAIN_KEY = 'redirect_to';

    case IMG_MAX_FILE_SIZE = '5120';
}