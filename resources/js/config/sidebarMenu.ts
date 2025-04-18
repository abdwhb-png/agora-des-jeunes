import { Menu, RapidLink } from "@/types/sidebar";
import { useStorage } from "@vueuse/core";
import { markRaw } from "vue";

import AgoraSessions from "@/Pages/Gestion/Partials/AgoraSessions.vue";
import Polls from "@/Pages/Gestion/Partials/Polls.vue";
import UsersList from "@/Pages/Gestion/Partials/Users/UsersList.vue";
import AddUser from "@/Pages/Gestion/Partials/Users/AddUser.vue";
import Overview from "@/Pages/Gestion/Partials/Overview.vue";
import Faqs from "@/Pages/Gestion/Partials/Faqs.vue";
import { getIcon } from "@/utils/helpers";
import Settings from "@/Pages/Gestion/Partials/Configuration/SiteSettings/Settings.vue";
import SocialLinks from "@/Pages/Gestion/Partials/Configuration/SiteSettings/SocialLinks.vue";
import Departements from "@/Pages/Gestion/Partials/Configuration/Departements.vue";
import Trainings from "@/Pages/Gestion/Partials/Configuration/Trainings.vue";
import Jobs from "@/Pages/Gestion/Partials/Configuration/Jobs.vue";

import { appUrl, apiManagerUrl, cvBuilderUrl } from "./appInit";

export const rapidLinks: RapidLink[] = [
    {
        label: "Accueil du Site",
        url: appUrl,
        icon: "ki-filled ki-home",
    },
    {
        label: "Mon Compte",
        route: "account",
        icon: getIcon("account"),
    },
    {
        label: "Constructeur de CV",
        url: cvBuilderUrl,
        icon: getIcon("cv"),
    },
    {
        label: "API Manger",
        url: apiManagerUrl || route("api-tokens.index"),
        icon: "ki-filled ki-code",
    },
    {
        label: "Pulse",
        url: "/pulse",
        icon: "ki-filled ki-pulse",
    },
    {
        label: "Telescope",
        url: "/telescope",
        icon: "ki-filled ki-chart-line-star",
    },
];

const base = [
    {
        title: "Mon Compte",
        description: "Gérer les informations de votre compte.",
        icon: getIcon("account"),
        route: "account",
        selected: useStorage("account_active", 0),
    },
    {
        title: "Paramètres",
        description: "Configurer les paramètres de l'application.",
        icon:  getIcon("settings"),
        route: "settings",
        selected: useStorage("settings_active", 0),
    },
];

export function menus(routePrefix: string): Menu[] {
    const gestion = [
        {
            title: "Dashboard",
            icon: "ki-home-1",
            route: routePrefix + "dashboard",
            selected: useStorage("dashboard_active", 0),
            description: "Vue d'ensemble des activités et statistiques.",
            items: [
                {
                    name: "Vue d'ensemble",
                    component: markRaw(Overview),
                },
                {
                    name: "Sessions Agora",
                    description: "Gérer les sessions Agora.",
                    component: markRaw(AgoraSessions),
                },
                {
                    name: "Sondages",
                    description: "Gérer les sondages.",
                    component: markRaw(Polls),
                },
                {
                    name: "Foire Aux Questions",
                    description: "Gérer les questions fréquentes.",
                    component: markRaw(Faqs),
                },
            ],
        },
        {
            title: "Utilisateurs",
            icon: "ki-users",
            route: routePrefix + "users",
            selected: useStorage("users_active", 0),
            description: "Gérer les utilisateurs et leurs informations.",
            items: [
                {
                    name: "Liste",
                    description: "Afficher la liste des utilisateurs.",
                    component: markRaw(UsersList),
                },
                {
                    name: "Ajouter",
                    description: "Ajouter un nouvel utilisateur.",
                    component: markRaw(AddUser),
                },
            ],
        },
        {
            title: "Configuration",
            icon: "ki-category",
            route: routePrefix + "configuration",
            selected: useStorage("configuration_active", 0),
            description: "Gérer les paramètres et configurations du site.",
            items: [
                {
                    name: "Formations",
                    description: "Gérer les formations disponibles.",
                    component: markRaw(Trainings),
                },
                {
                    name: "Jobs",
                    description: "Gérer les offres d'emploi.",
                    component: markRaw(Jobs),
                },
                {
                    name: "Départements",
                    description: "Gérer les départements et leurs informations.",
                    component: markRaw(Departements),
                },
                {
                    name: "Réseaux Sociaux",
                    description: "Configurer les liens vers les réseaux sociaux.",
                    component: markRaw(SocialLinks),
                },
                {
                    name: "Réglages du site",
                    description: "Configurer les paramètres généraux du site.",
                    component: markRaw(Settings),
                },
            ],
        },
        {
            title: "Roles",
            icon: getIcon("role"),
            route: routePrefix + "role.index",
            selected: useStorage("roles_active", 0),
            description: "Gérer les rôles et leurs permissions.",
        },
        {
            title: "Permissions",
            icon: getIcon("permission"),
            route: routePrefix + "permission.index",
            selected: useStorage("permissions_active", 0),
            description: "Configurer les permissions pour les utilisateurs.",
        },
        ...base,
    ];

    const user = [
        {
            title: "Tableau de bord",
            icon: "ki-element-11",
            route: routePrefix + "dashboard",
            selected: useStorage("dashboard_active", 0),
            description: "Accéder à votre tableau de bord personnel.",
        },
        {
            title: "Entreprendre",
            icon: getIcon("entreprendre"),
            route: routePrefix + "entreprendre",
            selected: useStorage("entreprenariat_active", 0),
            description: "Explorer les ressources pour entreprendre.",
        },
        {
            title: "Se Former",
            icon: getIcon("formation"),
            route: routePrefix + "formation",
            selected: useStorage("trainings_active", 0),
            description: "Accéder aux formations disponibles.",
        },
        {
            title: "Jobs & Emplois",
            icon: getIcon("emploi"),
            route: routePrefix + "emploi",
            selected: useStorage("jobs_active", 0),
            description: "Rechercher des opportunités d'emploi.",
        },
        ...base,
    ];

    return routePrefix === "gestion." ? gestion : user;
}
