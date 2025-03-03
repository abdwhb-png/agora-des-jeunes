<?php

namespace App\Enums;

enum SeverityEnum: string
{
    case LOW = 'basse';
    case MEDIUM = 'moyenne';
    case HIGH = 'élevée';
    case CRITICAL = 'critique';


    public function color(): string
    {
        return match ($this) {
            self::LOW => '#1b84ff',
            self::MEDIUM => '#f6b100',
            self::HIGH => 'orange',
            self::CRITICAL => '#f8285a',
        };
    }

    public function weight(): int
    {
        return match ($this) {
            self::LOW => 5,
            self::MEDIUM => 25,
            self::HIGH => 50,
            self::CRITICAL => 100,
        };
    }

    public static function all(): array
    {
        return collect(self::cases())->map(fn($case) => [
            'value' => $case->value,
            'color' => $case->color(),
            'weight' => $case->weight(),
        ])->toArray();
    }
}
