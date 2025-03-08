<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case COMPLETED = 'Complété';
    case ONGOING = 'En cours';
    case DRAFT = 'Brouillon';
    case ARCHIVED = 'Archivé';
    case CANCELLED = 'Annulé';

    public function badge(): string
    {
        return match ($this) {
            self::COMPLETED => 'badge badge-success',
            self::ONGOING => 'badge badge-primary',
            self::DRAFT => 'badge badge-outline',
            self::ARCHIVED => 'badge badge-outline',
            self::CANCELLED => 'badge badge-danger',
        };
    }
}
