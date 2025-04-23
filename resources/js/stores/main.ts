import axios from "axios";
import { defineStore } from "pinia";
import { usePage } from "@inertiajs/vue3";
import { useAxios } from "@/composables/useAxios";

const page = usePage();
const { fetchData } = useAxios();

export const useMainStore = defineStore("main", {
    state: () => ({
        isScrolled: false,
        showContent: false,
        mainSearch: "",
        menuItems: [
            {
                label: "Accueil",
                route: "home",
                cache: "10s",
                description: "Retourner à la page d'accueil.",
            },
            {
                label: "A Propos",
                route: "about",
                description: "En savoir plus sur notre organisation.",
            },
            {
                label: "Contact",
                route: "contact",
                description: "Obtenez nos coordonnées pour nous joindre.",
            },
            {
                label: "Blog",
                route: "blog",
                description: "Lire nos articles et actualités.",
            },
        ],
        resourceItems: [
            {
                label: "Foire Aux Questions",
                href: route("faqs"),
                description: "Consultez les réponses aux questions fréquentes.",
            },
            {
                label: "Formations",
                href: "#",
                description: "Découvrez les formations disponibles.",
            },
            {
                label: "Emplois et Jobs",
                href: "#",
                description:
                    "Explorez les opportunités d'emploi et de carrière.",
            },
        ],
        faqs: [],
        polls: [],
        agoraSessions: [],
        trainings: [],
        jobOffers: [],
        appFeatures: [],
        departements: [],
        communes: [],
        arrondissements: [],
    }),

    actions: {
        setShowContent(value: boolean): void {
            this.showContent = value;
        },

        handleScroll(event: Event): void {
            const target = event.target as HTMLElement;
            this.isScrolled = target.scrollTop > 0;
        },

        async fetchPolls(url = "") {
            const data = await fetchData(
                url || route(page.props.routePrefix + "poll.index"),
                {
                    errorMessage: "Impossible de récupérer les sondages",
                },
            );

            if (data) {
                this.polls = data;
            }
        },

        async fetchFaqs(url = "") {
            const data = await fetchData(
                url || route(page.props.routePrefix + "faq.index"),
                {
                    errorMessage: "Impossible de récupérer les FAQ",
                },
            );

            if (data) {
                this.faqs = data;
            }
        },

        async fetchAgora(url = "") {
            const data = await fetchData(
                url || route(page.props.routePrefix + "agora-session.index"),
                {
                    errorMessage:
                        "Impossible de récupérer les sessions d'Agora",
                },
            );

            if (data) {
                this.agoraSessions = data;
            }
        },

        async fetchTrainings(url = "") {
            const data = await fetchData(
                url || route(page.props.routePrefix + "training.index"),
                {
                    errorMessage: "Impossible de récupérer les formations",
                },
            );

            if (data) {
                this.trainings = data;
            }
        },

        async fetchJobOffers(url = "") {
            const data = await fetchData(
                url || route(page.props.routePrefix + "job-offer.index"),
                {
                    errorMessage: "Impossible de récupérer les offres d'emploi",
                },
            );

            if (data) {
                this.jobOffers = data;
            }
        },

        async fetchFeatures() {
            const data = await fetchData("/features", {
                errorMessage: "Impossible de récupérer les fonctionnalités",
                useApi: true,
            });

            if (data) {
                this.appFeatures = (
                    data as { app_features: any[] }
                ).app_features;
            }
        },

        async fetchDepartements() {
            const data = await fetchData("/departements", {
                errorMessage:
                    "Impossible de récupérer les données géographiques",
                useApi: true,
            });

            if (data) {
                this.departements = data.departements || [];
                this.communes = data.communes || [];
                this.arrondissements = data.arrondissements || [];
            }
        },
    },
});
