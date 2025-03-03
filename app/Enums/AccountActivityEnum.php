<?php

namespace App\Enums;

enum AccountActivityEnum: string
{
    case LOGED_IN = 'Connexion';
    case LOGED_OUT = 'Déconnexion';
    case REGISTERED = 'Inscription';
    case FAILED_LOGIN = 'Connexion échouée';
    case SUSPICIOUS_LOGIN_ATTEMPT = 'Tentative de connexion suspecte';
    case PASSWORD_RESET = 'Mot de passe réinitialisé';
    case PASSWORD_UPDATED = 'Mot de passe modifié';
    case EMAIL_VERIFIED = 'Email verifié';
    case EMAIL_UPDATED = 'Email modifié';
    case ACCOUNT_DEACTIVATED = 'Compte désactivé';
    case PROFILE_PIC_UPDATED = 'Mise à jour du profil';
    case PROFILE_UPDATED = 'Mise à jour des informations';


    public function description(): string
    {
        return match ($this) {
            self::LOGED_IN => 'Nouvelle connexion à ton compte',
            self::LOGED_OUT => 'Ton compte a été déconnecté',
            self::REGISTERED => 'Tu t\'es inscrit sur la plateforme',
            self::PASSWORD_RESET => 'Le mot de passe de ton compte a été réinitialisé',
            self::PASSWORD_UPDATED => 'Le mot de passe de ton compte a été mis à jour',
            self::EMAIL_VERIFIED => 'Ton adresse email a été verifiée',
            self::EMAIL_UPDATED => 'Ton adresse email a été mis à jour',
            self::ACCOUNT_DEACTIVATED => 'Ton compte a éte désactivé',
            self::SUSPICIOUS_LOGIN_ATTEMPT => 'Tentative de connexion suspecte à ton compte',
            self::FAILED_LOGIN => 'Echec de connexion',
            self::PROFILE_PIC_UPDATED => 'Ta photo de profil a étée mise à jour',
            self::PROFILE_UPDATED => 'Tes informations personnelles ont été mises à jour',
            default => '',
        };
    }

    public function severity(): SeverityEnum
    {
        return match ($this) {
            self::LOGED_IN => SeverityEnum::LOW,
            self::LOGED_OUT => SeverityEnum::LOW,
            self::REGISTERED => SeverityEnum::LOW,
            self::PASSWORD_RESET => SeverityEnum::HIGH,
            self::PASSWORD_UPDATED => SeverityEnum::MEDIUM,
            self::EMAIL_VERIFIED => SeverityEnum::LOW,
            self::EMAIL_UPDATED => SeverityEnum::MEDIUM,
            self::ACCOUNT_DEACTIVATED => SeverityEnum::HIGH,
            self::SUSPICIOUS_LOGIN_ATTEMPT => SeverityEnum::CRITICAL,
            self::FAILED_LOGIN => SeverityEnum::MEDIUM,
            self::PROFILE_PIC_UPDATED => SeverityEnum::LOW,
            self::PROFILE_UPDATED => SeverityEnum::LOW,
            default => SeverityEnum::LOW,
        };
    }

    public static function all(): array
    {
        return collect(self::cases())->map(fn($case) => [
            'value' => $case->value,
            'description' => $case->description(),
            'severity' => array_find(SeverityEnum::all(), fn($severity) => $severity['value'] === $case->severity()->value),
        ])->toArray();
    }
}
