import axios from "axios";

export function useApi() {
    const api = axios.create({
        baseURL: "/api",
    });

    const uploadImage = async (formData) => {
        const response = await api.post("/upload-image", formData);
        return response.data.url || null;
    };

    api.interceptors.request.use((config) => {
        const token = localStorage.getItem("auth_token");
        config.headers.Authorization = `Bearer ${token}`;
        return config;
    });

    return { api, uploadImage };
}
