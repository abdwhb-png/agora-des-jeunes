import { useStorage } from "@vueuse/core";
import axios from "axios";

const base = import.meta.env.VITE_API_BASE_URL;

export function useExternalApi() {
    const api = axios.create({
        baseURL: base + "/api",
    });

    api.interceptors.request.use((config) => {
        const token = localStorage.getItem("auth_token");
        config.headers.Authorization = `Bearer ${token}`;
        return config;
    });

    return { api };
}
