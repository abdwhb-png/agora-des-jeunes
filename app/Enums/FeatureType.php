<?php

namespace App\Enums;

enum FeatureType: string
{
    case CV_CREATION = 'Création de CV';
    case JOB_SEARCH = 'Recherche d\'emploi';
    case SCHOLARSHIP_SEARCH = 'Recherche de bourses universitaires';
    case UNIVERSITY_RANKING = 'Classement des universités';
    case ENTREPRENEUR_GUIDE = 'Entreprenariat';
    case TENDER_SEARCH = 'Appels d\'offres';
    case PROFESSIONAL_NETWORK = 'Mise en relation avec des professionnels';

    public function description(): string
    {
        return match ($this) {
            self::CV_CREATION => 'Obtiens un CV professionnel en quelques clics.',
            self::JOB_SEARCH => 'Trouve des opportunités adaptées à ton profil.',
            self::SCHOLARSHIP_SEARCH => 'Découvre les meilleures aides financières pour poursuivre tes études.',
            self::UNIVERSITY_RANKING => 'Oriente-toi vers les meilleures écoles au Bénin et dans le monde.',
            self::ENTREPRENEUR_GUIDE => 'Tu veux lancer ton projet ? Suis nos guides et conseils pratiques.',
            self::TENDER_SEARCH => 'Accède aux opportunités pour booster ton activité.',
            self::PROFESSIONAL_NETWORK => 'Trouve des mentors et des contacts clés pour ton avenir.',
        };
    }
}
