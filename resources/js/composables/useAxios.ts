import { ref } from "vue";
import axios from "axios";
import { useApi } from "./useApi";
import { toast } from "vue-sonner";

const { api } = useApi();

export function useAxios<T>() {
    const loading = ref(false);
    const error = ref<string | null>(null);
    const data = ref<T | null>(null);

    /**
     * Centralized error handler for request errors
     * @param {any} err - The error object
     * @param {string} endpoint - The endpoint that was called
     * @param {string} action - The action being performed (fetching, posting, etc.)
     * @param {string} errorMessage - User-friendly error message to display in toast
     * @returns {string} - Detailed error description
     */
    const handleError = (
        err: any,
        endpoint: string,
        action: string,
        errorMessage: string,
    ): string => {
        let errorDescription = "Une erreur est survenue.";

        if (err.response) {
            // The request was made, and the server responded with a status code
            // that falls out of the range of 2xx
            errorDescription = `Erreur serveur (${err.response.status}): ${err.response.data?.message || err.response.statusText}`;
        } else if (err.request) {
            // The request was made, but no response was received
            errorDescription =
                "Aucune réponse du serveur. Vérifiez votre connexion réseau.";
        } else {
            // Something happened in setting up the request that triggered an Error
            errorDescription = `Erreur de configuration: ${err.message}`;
        }

        console.error(`Error while ${action} ${endpoint} using useAxios:`, err);
        error.value = errorDescription; // Store the detailed error

        toast(errorMessage, {
            description: errorDescription,
            // variant: "danger",  // If needed
        });

        return errorDescription;
    };

    /**
     * Fetch function using Axios to handle  requests and errors
     * @param {string} endpoint -  endpoint
     * @param {object} options - Request options (currently only errorMessage)
     * @returns {Promise<T | null>} - The response data or null if error
     */
    const fetchData = async (
        endpoint: string,
        options: {
            errorMessage?: string;
            useApi?: boolean;
        } = {},
    ): Promise<T | null> => {
        const {
            errorMessage = "Impossible de récupérer les données",
            useApi = false,
        } = options;

        loading.value = true;
        error.value = null;
        data.value = null; // Reset data on new fetch

        try {
            const response = useApi
                ? await api.get(endpoint)
                : await axios.get(endpoint);
            data.value = response.data;
            return response.data;
        } catch (err: any) {
            handleError(err, endpoint, "fetching from", errorMessage);
            return null;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Post data to an endpoint
     * @param {string} endpoint - endpoint
     * @param {any} postData - Data to send in the request body
     * @param {object} options - Request options
     * @returns {Promise<T | null>} - The response data or null if error
     */
    const postData = async (
        endpoint: string,
        postData: any,
        options: {
            errorMessage?: string;
            useApi?: boolean;
        } = {},
    ): Promise<T | null> => {
        const {
            errorMessage = "Impossible d'envoyer les données",
            useApi = false,
        } = options;

        loading.value = true;
        error.value = null;
        data.value = null;

        try {
            const response = useApi
                ? await api.post(endpoint, postData)
                : await axios.post(endpoint, postData);
            data.value = response.data;
            return response.data;
        } catch (err: any) {
            handleError(err, endpoint, "posting to", errorMessage);
            return null;
        } finally {
            loading.value = false;
        }
    };

    const uploadImage = async (formData) => {
        const data = await postData("/upload-image", formData);
        return data?.url || null;
    };

    return {
        loading,
        error,
        data, // Return the fetched data as well
        fetchData,
        postData,
        uploadImage,
    };
}
