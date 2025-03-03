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

import { appUrl } from "./appInit";

export const rapidLinlks: RapidLink[] = [
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
        title: "Paramètres",
        icon: "ki-setting-2",
        route: "settings",
        selected: useStorage("settings_active", 0),
    },
    {
        title: "Mon Compte",
        icon: getIcon("account"),
        route: "account",
        selected: useStorage("account_active", 0),
    },
];

export function menus(routePrefix: string): Menu[] {
    const gestion = [
        {
            title: "Dashboard",
            icon: "ki-home-1",
            route: routePrefix + "dashboard",
            selected: useStorage("dashboard_active", 0),
            items: [
                {
                    name: "Vue d'ensemble",
                    icon: "",
                    component: markRaw(Overview),
                },
                {
                    name: "Sessions Agora",
                    icon: "",
                    component: markRaw(AgoraSessions),
                },
                {
                    name: "Sondages",
                    icon: "",
                    component: markRaw(Polls),
                },
                {
                    name: "Foire Aux Questions",
                    icon: "",
                    component: markRaw(Faqs),
                },
            ],
        },
        {
            title: "Configuration",
            icon: "ki-category",
            route: routePrefix + "configuration",
            selected: useStorage("configuration_active", 0),
            items: [
                {
                    name: "Formations",
                    component: markRaw(Trainings),
                },
                {
                    name: "Jobs",
                    component: markRaw(Jobs),
                },
                {
                    name: "Départements",
                    component: markRaw(Departements),
                },
                {
                    name: "Réseaux Sociaux",
                    component: markRaw(SocialLinks),
                },
                {
                    name: "Réglages du site",
                    component: markRaw(Settings),
                },
            ],
        },
        {
            title: "Utilisateurs",
            icon: "ki-users",
            route: routePrefix + "users",
            selected: useStorage("users_active", 0),
            items: [
                {
                    name: "Liste",
                    component: markRaw(UsersList),
                },
                {
                    name: "Ajouter",
                    component: markRaw(AddUser),
                },
            ],
        },
        {
            title: "Roles",
            icon: getIcon("role"),
            route: routePrefix + "role.index",
            selected: useStorage("roles_active", 0),
        },
        {
            title: "Permissions",
            icon: getIcon("permission"),
            route: routePrefix + "permission.index",
            selected: useStorage("permissions_active", 0),
        },
        {
            title: "API",
            icon: "ki-code",
            route: "api-tokens.index",
            selected: useStorage("api_active", 0),
        },
        ...base,
    ];

    const user = [
        {
            title: "Tableau de bord",
            icon: "ki-element-11",
            route: routePrefix + "dashboard",
            selected: useStorage("dashboard_active", 0),
        },
        {
            title: "Entreprendre",
            icon: getIcon("entreprendre"),
            route: routePrefix + "entreprendre",
            selected: useStorage("entreprenariat_active", 0),
        },
        {
            title: "Se Former",
            icon: getIcon("formation"),
            route: routePrefix + "formation",
            selected: useStorage("trainings_active", 0),
        },
        {
            title: "Jobs & Emplois",
            icon: getIcon("emploi"),
            route: routePrefix + "emploi",
            selected: useStorage("jobs_active", 0),
        },
        {
            title: "Mon Profil",
            icon: getIcon("profil"),
            route: "profil",
            selected: useStorage("profil_active", 0),
        },
        ...base,
    ];

    return routePrefix === "gestion." ? gestion : user;
}
