<?php

namespace App\Enums;

enum RolesEnum: string
{
        // case NAMEINAPP = 'name-in-database';

    case USER = 'utilisateur';
    case MANAGER = 'manager';
    case ADMIN = 'admininistrateur';
    case SUPERADMIN = 'super-administrateur';
    case ROOT = 'root';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::USER => 'Role Utilisateur',
            static::ADMIN => 'Role Administrateur',
            static::SUPERADMIN => 'Role Super-Administrateur',
            static::ROOT => 'Role Root',
        };
    }

    public function description(): string
    {
        return match ($this) {
            static::USER => "C'est le role d'un simple utilisateur de la plateforme.",
            static::ADMIN => "C'est le role d'un administrateur de la plateforme.",
            static::MANAGER => "C'est le role d'un manager de la plateforme.",
            static::SUPERADMIN => "C'est le role d'un super-administrateur de la plateforme.",
            static::ROOT => 'This is the root role.',
        };
    }
}
