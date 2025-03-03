<?php

namespace Database\Seeders;

use App\Enums\FeatureType;
use App\Models\FAQ;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // A propos
            [
                'question' => 'Qu’est-ce qu’' . config('app.name') . ' ?',
                'answer' => '' . config('app.name') . ' est une plateforme dédiée aux jeunes de 15 à 35 ans pour les accompagner dans leur éducation, leur insertion professionnelle et leur engagement citoyen.',
                'category' => 'À propos',
            ],
            [
                'question' => 'Qui peut utiliser ' . config('app.name') . ' ?',
                'answer' => 'Tous les jeunes âgés de 15 à 35 ans résidant au Bénin ou ailleurs peuvent s’inscrire et profiter de nos services gratuitement.',
                'category' => 'À propos',
            ],
            [
                'question' => config('app.name') . ' est-il un service gratuit ?',
                'answer' => 'Oui ! L’accès à nos principales fonctionnalités est 100% gratuit.',
                'category' => 'À propos',
            ],

            // Sécurité et confidentialité & Assistance
            [
                'question' => 'Mes données personnelles sont-elles protégées ?',
                'answer' => 'Oui ! Nous mettons en place des mesures strictes pour protéger tes informations personnelles.',
                'category' => 'Sécurité et confidentialité',
            ],
            [
                'question' => 'Comment contacter l’équipe d’' . config('app.name') . ' ?',
                'answer' => 'Tu peux nous écrire par e-mail ou utiliser le chat en ligne sur notre site.',
                'category' => 'Assistance',
            ],

            // Création de CV
            [
                'question' => 'Comment créer un CV sur ' . config('app.name') . ' ?',
                'answer' => 'Tu peux créer ton CV en remplissant un formulaire simple avec tes informations personnelles, tes expériences et tes compétences. Une fois terminé, tu peux télécharger ton CV en PDF ou le partager en ligne.',
                'category' => FeatureType::CV_CREATION->value,
            ],
            [
                'question' => 'Puis-je modifier mon CV après l’avoir créé ?',
                'answer' => 'Oui ! Tu peux mettre à jour ton CV à tout moment depuis ton espace personnel.',
                'category' => FeatureType::CV_CREATION->value,
            ],
            [
                'question' => 'Puis-je télécharger mon CV en PDF ?',
                'answer' => 'Oui, une fois ton CV créé, tu peux le télécharger en format PDF.',
                'category' => FeatureType::CV_CREATION->value,
            ],
            [
                'question' => 'Comment rendre mon CV plus attractif ?',
                'answer' => 'Utilise une photo professionnelle, mets en avant tes compétences clés et vérifie l’orthographe avant de le télécharger.',
                'category' => FeatureType::CV_CREATION->value,
            ],

            // Recherche d'emploi
            [
                'question' => 'Comment trouver un emploi sur ' . config('app.name') . ' ?',
                'answer' => 'Utilise notre moteur de recherche d’emplois et filtre les offres selon ton domaine d’expertise et ta localisation.',
                'category' => FeatureType::JOB_SEARCH->value,
            ],
            [
                'question' => 'Est-ce que les offres d’emploi sont mises à jour régulièrement ?',
                'answer' => 'Oui, notre base de données est mise à jour quotidiennement pour proposer les dernières opportunités disponibles.',
                'category' => FeatureType::JOB_SEARCH->value,
            ],
            [
                'question' => 'Puis-je être alerté lorsqu’une offre correspond à mon profil ?',
                'answer' => 'Oui ! Active les notifications dans ton espace personnel et sois informé dès qu’une offre qui te correspond est publiée.',
                'category' => FeatureType::JOB_SEARCH->value,
            ],

            // Recherche de bourses universitaires
            [
                'question' => 'Quelles bourses sont disponibles pour les étudiants béninois ?',
                'answer' => 'Nous recensons les bourses locales et internationales accessibles aux étudiants béninois.',
                'category' => FeatureType::SCHOLARSHIP_SEARCH->value,
            ],
            [
                'question' => 'Comment trouver une bourse d’études ?',
                'answer' => 'Notre moteur de recherche te permet de filtrer les bourses disponibles selon ton niveau d’études et ton domaine.',
                'category' =>  FeatureType::SCHOLARSHIP_SEARCH->value,
            ],
            [
                'question' => 'Les bourses sont-elles uniquement pour les étudiants béninois ?',
                'answer' => 'Non, certaines bourses sont ouvertes aux étudiants d’autres pays africains. Consulte les critères d’éligibilité de chaque offre pour vérifier ton admissibilité.',
                'category' =>  FeatureType::SCHOLARSHIP_SEARCH->value,
            ],
            [
                'question' => 'Comment postuler à une bourse sur la plateforme ?',
                'answer' => 'Chaque bourse possède ses propres critères et modalités de candidature. Nous affichons toutes les informations nécessaires pour t’aider à soumettre un dossier complet.',
                'category' => FeatureType::SCHOLARSHIP_SEARCH->value,
            ],

            // Classement des universités
            [
                'question' => 'Puis-je comparer les meilleures universités au Bénin ?',
                'answer' => 'Oui ! Nous avons une section qui classe les meilleures universités du Bénin en fonction',
                'category' => FeatureType::UNIVERSITY_RANKING->value,
            ],
            [
                'question' => 'Comment trouver les meilleures universités à l’étranger pour les étudiants béninois ?',
                'answer' => 'Nous avons sélectionné une liste d’universités internationales qui offrent des programmes adaptés aux étudiants béninois et des opportunités de bourses.',
                'category' => FeatureType::UNIVERSITY_RANKING->value,
            ],
            [
                'question' => 'Quels critères sont utilisés pour classer les universités ?',
                'answer' => 'Nous nous basons sur des critères comme la qualité de l’enseignement, les infrastructures, et la reconnaissance internationale.',
                'category' => FeatureType::UNIVERSITY_RANKING->value,
            ],
            [
                'question' => 'Comment puis-je comparer plusieurs universités ?',
                'answer' => 'Utilise notre comparateur d’universités pour voir les différences entre plusieurs établissements.',
                'category' => FeatureType::UNIVERSITY_RANKING->value,
            ],

            // Guide pour entrepreneurs
            [
                'question' => 'Quels sont les premiers pas pour créer une entreprise au Bénin ?',
                'answer' => 'Nous avons un guide détaillé expliquant les étapes essentielles pour lancer ton entreprise.',
                'category' => FeatureType::ENTREPRENEUR_GUIDE->value,
            ],
            [
                'question' => 'Quels sont les financements disponibles pour les jeunes entrepreneurs ?',
                'answer' => 'Nous recensons les opportunités de financement et d’accompagnement pour les jeunes entrepreneurs béninois.',
                'category' => FeatureType::ENTREPRENEUR_GUIDE->value,
            ],
            [
                'question' => 'Quels sont les organismes qui aident les entrepreneurs au Bénin ?',
                'answer' => 'Nous te fournissons une liste d’incubateurs, d’organismes de financement et d’accompagnement pour t’aider à concrétiser ton projet.',
                'category' => FeatureType::ENTREPRENEUR_GUIDE->value,
            ],

            // Recherche d’appels d’offres
            [
                'question' => 'Comment trouver des appels d’offres pertinents ?',
                'answer' => 'Nous regroupons des appels d’offres publics et privés par domaine, budget et échéance. Tu peux filtrer ceux qui correspondent à ton domaine.',
                'category' => FeatureType::TENDER_SEARCH->value,
            ],
            [
                'question' => 'Puis-je recevoir des notifications sur les nouveaux appels d’offres ?',
                'answer' => 'Oui, tu peux activer les alertes pour recevoir les offres correspondant à tes critères par email.',
                'category' => FeatureType::TENDER_SEARCH->value,
            ],

            // Mise en relation avec des professionnels
            [
                'question' => 'Comment entrer en contact avec un mentor ou un expert ?',
                'answer' => 'Nous avons une section où tu peux te connecter avec des professionnels et mentors pour t’accompagner.',
                'category' => FeatureType::PROFESSIONAL_NETWORK->value,
            ],
            [
                'question' => 'Les consultations avec des professionnels sont-elles gratuites ?',
                'answer' => 'Certaines consultations sont gratuites, d’autres peuvent être payantes selon l’expert.',
                'category' => FeatureType::PROFESSIONAL_NETWORK->value,
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::create($faq);
        }

        // DB::table('f_a_q_s')->insert($faqs);
    }
}