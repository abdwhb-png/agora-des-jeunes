<?php

namespace App\Enums;

enum SeoMeta: string
{
    case ABOUTUS = "A propos";
    case CONTACTUS = "Contact";
    case FAQS = "Foire aux questions";
    // case TRAININGS = "Formations";
    // case JOBS = "Emplois et Jobs";

    public function theMeta(): array
    {
        $data = array_map(fn($item) => [
            'title' => $item->value,
            'description' => $item->description(),
            'keywords' => $item->keywords(),
        ], self::cases());

        // Convertir en tableau associatif pour un accès plus fiable
        $data = array_column($data, null, 'title');

        return $data[$this->value] ?? reset($data);
    }

    public function description(): string
    {
        return match ($this) {
            static::ABOUTUS => "Découvre " . config('app.name') . ", l'initiative créée pour répondre aux besoins éducatifs et sociaux des jeunes.",
            static::FAQS => "Trouve les réponses aux questions les plus populaires sur " . config('app.name') . ".",
            static::CONTACTUS => "Tu as des questions sur " . config('app.name') . " ? Besoin d’informations sur nos services ? Contacte-nous via notre formulaire ou par email.",
            default => seo('description'),
        };
    }

    public function keywords(): string
    {
        $result = match ($this) {
            static::ABOUTUS => "jeunes, emploi, entrepreneuriat, formation, bourses, financement, mentorat, développement personnel",
            static::CONTACTUS => "contact, assistance, support, informations, aide",
            static::FAQS => "faqs, questions, conseils",
            default => seo('keywords'),
        };

        return config('app.name') . ', ' . $result;
    }
}
