import { ref } from "vue";
import axios from "axios";

interface ApiResponse<T> {
    data: T;
    message?: string;
    errors?: Record<string, string[]>;
}

interface PaginatedResponse<T> {
    data: T[];
    meta: {
        current_page: number;
        from: number;
        last_page: number;
        per_page: number;
        to: number;
        total: number;
    };
}

export function useApi<T>() {
    const api = axios.create({
        baseURL: "/api",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
    });

    const loading = ref(false);
    const error = ref<string | null>(null);

    const fetchData = async (
        endpoint: string,
        params?: Record<string, any>,
    ): Promise<T | null> => {
        loading.value = true;
        error.value = null;

        try {
            const response = await api.get<ApiResponse<T>>(endpoint, {
                params,
            });
            return response.data.data;
        } catch (err: any) {
            error.value =
                err.response?.data?.message || "Une erreur est survenue";
            return null;
        } finally {
            loading.value = false;
        }
    };

    const postData = async (endpoint: string, data: any): Promise<T | null> => {
        loading.value = true;
        error.value = null;

        try {
            const response = await api.post<ApiResponse<T>>(endpoint, data);
            return response.data.data;
        } catch (err: any) {
            error.value =
                err.response?.data?.message || "Une erreur est survenue";
            return null;
        } finally {
            loading.value = false;
        }
    };

    const updateData = async (
        endpoint: string,
        data: any,
    ): Promise<T | null> => {
        loading.value = true;
        error.value = null;

        try {
            const response = await api.put<ApiResponse<T>>(endpoint, data);
            return response.data.data;
        } catch (err: any) {
            error.value =
                err.response?.data?.message || "Une erreur est survenue";
            return null;
        } finally {
            loading.value = false;
        }
    };

    const deleteData = async (endpoint: string): Promise<boolean> => {
        loading.value = true;
        error.value = null;

        try {
            await api.delete(endpoint);
            return true;
        } catch (err: any) {
            error.value =
                err.response?.data?.message || "Une erreur est survenue";
            return false;
        } finally {
            loading.value = false;
        }
    };

    return {
        loading,
        error,
        api,
        fetchData,
        postData,
        updateData,
        deleteData,
    };
}
