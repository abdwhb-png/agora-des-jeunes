import { useApi } from "@/composables/useApi";
import axios from "axios";
import { defineStore } from "pinia";

const { api } = useApi();

export const useMainStore = defineStore("main", {
    state: () => ({
        isScrolled: false,
        showContent: false,
        mainSearch: "",
        menuItems: [
            { label: "Accueil", route: "home", cache: "10s", description: "Retourner à la page d'accueil." },
            { label: "A Propos", route: "about", description: "En savoir plus sur notre organisation." },
            { label: "Contact", route: "contact", description: "Obtenez nos coordonnées pour nous joindre." },
            { label: "Blog", route: "blog", description: "Lire nos articles et actualités." },
        ],
        resourceItems: [
            { label: "Foire Aux Questions", href: route("faqs"), description: "Consultez les réponses aux questions fréquentes." },
            { label: "Formations", href: "#", description: "Découvrez les formations disponibles." },
            { label: "Emplois et Jobs", href: "#", description: "Explorez les opportunités d'emploi et de carrière." },
        ],
        faqs: [],
        polls: [],
        agoraSessions: [],
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

        async fetchPolls() {
            await axios
                .get("/poll")
                .then((response: any) => {
                    this.polls = response.data;
                })
                .catch((error: any) => {
                    console.log("Error while fetching polls", error);
                });
        },

        async fetchFaqs() {
            await axios
                .get("/faq")
                .then((response: any) => {
                    this.faqs = response.data;
                })
                .catch((error: any) => {
                    console.log("Error while fetching faqs", error);
                });
        },

        async fetchAgora() {
            await axios
                .get("/agora-session")
                .then((response: any) => {
                    this.agoraSessions = response.data;
                })
                .catch((error: any) => {
                    console.log("Error while fetching agora sesssions", error);
                });
        },

        async fetchFeatures() {
            await api
                .get("/features")
                .then((response: any) => {
                    this.appFeatures = response.data.app_features;
                })
                .catch((error: any) => {
                    console.log("Error while fetching features", error);
                });
        },

        async fetchDepartements() {
            await api
                .get("/departements")
                .then((response: any) => {
                    this.departements = response.data.departements || [];
                    this.communes = response.data.communes || [];
                    this.arrondissements = response.data.arrondissements || [];
                })
                .catch((error: any) => {
                    console.log("Error while fetching departements", error);
                });
        },
    },
});
