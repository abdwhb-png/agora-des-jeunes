import { Menu, RapidLink } from "@/types/sidebar";
import { useStorage } from "@vueuse/core";
import { markRaw } from "vue";

import UsersList from "@/Pages/Gestion/Partials/Users/UsersList.vue";
import AddUser from "@/Pages/Gestion/Partials/Users/AddUser.vue";
import { getIcon } from "@/utils/helpers";

import { appUrl, cvBuilderUrl } from "./appInit";

export const rapidLinks: RapidLink[] = [
    {
        label: "Accueil du Site",
        url: appUrl,
        icon: "ki-filled ki-home",
    },
    {
        label: "Tableau de Bord",
        route: "dashboard",
        icon: getIcon("dashboard"),
    },
    {
        label: "Constructeur de CV",
        url: cvBuilderUrl,
        icon: getIcon("cv"),
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
        icon: getIcon("settings"),
        route: "settings",
        selected: useStorage("settings_active", 0),
    },
];

export function menus(routePrefix: string): Menu[] {
    const gestion = [
        {
            title: "Panel",
            icon: getIcon("dashboard"),
            route: routePrefix + "dashboard",
            selected: useStorage("dashboard_active", 0),
            description: "Accéder au tableau de bord d'administration.",
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
        },
        {
            title: "Roles",
            icon: getIcon("role"),
            route: routePrefix + "roles",
            selected: useStorage("roles_active", 0),
            description: "Gérer les rôles et leurs permissions.",
        },
        {
            title: "Permissions",
            icon: getIcon("permission"),
            route: routePrefix + "permissions",
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
            title: "Mes Projets",
            icon: getIcon("projet"),
            route: routePrefix + "projets",
            selected: useStorage("project_active", 0),
            description: "Accéder à votre tableau de bord personnel.",
        },
        {
            title: "Entreprendre",
            icon: getIcon("entreprendre"),
            route: routePrefix + "entreprendre",
            selected: useStorage("entrepreneurship_active", 0),
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
