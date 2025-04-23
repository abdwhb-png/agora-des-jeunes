import { defineStore, acceptHMRUpdate } from "pinia";
import { toast } from "vue-sonner";

export const useAdminStore = defineStore("adminStore", () => {
    const fetchData = async (url, params = {}) => {
        try {
            const response = await axios.get(url, { params });
            return response.data;
        } catch (error) {
            console.error("Error fetching data:", error);
            toast("Impossible de récupérer les données", {
                description: "Une erreur est survenue lors de la récupération des données.",
                variant: "danger",
            });
            throw error;
        }
    }

    return { fetchData };
});