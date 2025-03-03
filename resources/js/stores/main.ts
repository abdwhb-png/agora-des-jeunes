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
            { label: "Accueil", route: "home", cache: "10s" },
            { label: "Contact", route: "contact" },
            { label: "A Propos", route: "about" },
            { label: "Blog", route: "blog" },
        ],
        resourceItems: [
            { label: "Foire Aux Questions", href: route("faqs") },
            { label: "Formations", href: "#" },
            { label: "Emplois et Jobs", href: "#" },
            { label: "...", href: "#" },
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
