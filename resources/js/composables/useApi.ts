import axios from "axios";

export function useApi() {
    const api = axios.create({
        baseURL: "/api",
    });

    const uploadImage = async (formData) => {
        const response = await api.post("/upload-image", formData);
        // alert(response.data);
        return response.data.url || null;
    };

    return { api, uploadImage };
}
