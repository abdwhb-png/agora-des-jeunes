<p align="center"><a href="https://agora-jeuenes.com" target="_blank"><img src="https://agora-jeunes.com/medias/logo.png" width="400" alt="Logo Agora des Jeunes"></a></p>

## 📌 Introduction

**Agora des Jeunes** est une plateforme dédiée à l’éducation, à l’entrepreneuriat et au développement personnel des jeunes de 15 à 35 ans. Elle propose des outils intelligents pour aider les utilisateurs à bâtir leur avenir à travers diverses fonctionnalités.

## 🚀 Fonctionnalités principales

### 🎓 **Éducation et carrière**

- **📄 Création de CV** : Génération et personnalisation de CV professionnels.
- **🔎 Recherche d’emploi** : Accès à des offres d’emploi pertinentes.
- **🎓 Recherche de bourses** : Trouver des opportunités de financement pour les études.
- **🏛️ Classement des universités** : Comparer les meilleures universités au Bénin et dans le monde.

### 💼 **Entrepreneuriat et financement**

- **📑 Aide à la rédaction de projet** : Génération de documents professionnels pour les entrepreneurs et associations.
- **💰 Recherche de financements** : Accès aux subventions et investisseurs.
- **📢 Recherche d’appels d’offres** : Trouver des opportunités de marché.
- **🤝 Mise en relation avec des professionnels** : Développer son réseau.
- **📝 Gestion de projet** : Création et suivi des projets entrepreneuriaux.

### 🛠️ **IA et outils intelligents**

- **🤖 Personnalisation à l’IA** : Assistance intelligente pour structurer les projets et améliorer les CV.
- **📊 Analyse et recommandations** : Conseils adaptés aux utilisateurs.

---

### 👥 **Administration et sécurité**

- **👨‍💼 Gestion des utilisateurs** : Administration complète des comptes utilisateurs.
- **🔐 Gestion des rôles** : Contrôle d'accès granulaire avec permissions.
- **⚙️ Configuration du site** : Paramètres système et intégrations.
- **📊 Statistiques** : Tableaux de bord et analyses d'utilisation.
- **🔄 Gestion des sessions** : Contrôle et sécurité des connexions.

---

## 🏗️ Stack technologique

### Backend

- **Laravel 11.44** (API RESTful)
- **MySQL** (Base de données)
- **n8n** (Automatisation des tâches)
- **Sanctum** (Authentification API)
- **Jetstream & Fortify** (Gestion des utilisateurs)
- **Permissions & Rôles** (Spatie/Laravel-permission)

### Frontend

- **Vue.js 3 (Inertia) + PrimeVue + Shadcn Vue** (UI moderne et réactive)
- **Tailwind CSS** (Design flexible)

### Frontend CV Builder

- **React 18 + Shadcn React** (UI moderne et réactive)
- **Tailwind CSS** (Design flexible)

### Intelligence Artificielle

- **LLM open-source (Mistral-7B, LLaMA 3, etc)**
- **Base de données vectorielles** : (Qdrant)
- **Hébergement via Hugging Face ou Groq API**
- **Intégration d'agents IA avec n8n**

---

## 🚀 Installation et développement

1. **Prérequis**

    - PHP 8.2+
    - Composer 2.5+
    - Node.js 18+
    - MySQL 8.0+

2. **Installation**

    ```bash
    # Cloner le projet
    git clone https://github.com/votre-organisation/agora-jeunes.git
    cd agora-jeunes

    # Installation des dépendances
    composer install
    npm install

    # Configuration
    cp .env.example .env
    php artisan key:generate

    # Base de données
    php artisan migrate --seed

    # Lancer le serveur de développement
    php artisan serve
    npm run dev
    ```

3. **Configuration de l'environnement**
    - Configurer les variables d'environnement dans `.env`
    - Configurer les services d'authentification
    - Configurer l'accès à la base de données

---

## 🎯 Objectifs du projet

- **💡 Donner aux jeunes les moyens de réussir** grâce à des outils numériques avancés.
- **🌍 Encourager l'entrepreneuriat et l'innovation** en facilitant l'accès aux ressources.
- **📚 Améliorer l'éducation** avec des opportunités de formation et d'emploi.
