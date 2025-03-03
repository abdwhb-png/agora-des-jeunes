// stores/gestionFilterStore.js
import { defineStore } from "pinia";
import { useStorage } from "@vueuse/core";

const base = { search: "", status: "", per_page: 10, page: 1 };

export const useGestionFilterStore = defineStore("gestionFilterStore", {
    state: () => ({
        filters: {
            users: useStorage("users_filters", { ...base, role: "" }),
            polls: useStorage("polls_filters", {
                ...base,
                category: "",
                isActive: "",
            }),
            sondages: useStorage("sondages_filters", {
                ...base,
                type: "",
                date: "",
            }),
        },
    }),
    actions: {
        setFilter(type, key, value) {
            if (this.filters[type] && key in this.filters[type]) {
                this.filters[type][key] = value;
            }
        },
        resetFilters(type) {
            if (this.filters[type]) {
                Object.keys(this.filters[type]).forEach((key) => {
                    this.filters[type][key] = base[key];
                });
            }
        },
    },
});
