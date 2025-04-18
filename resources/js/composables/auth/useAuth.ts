import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useApi } from '../api/useApi';
import { API_ENDPOINTS } from '@/config/constants';
import type { User } from '@/types/models/user';

export function useAuth() {
    const router = useRouter();
    const { loading, error, postData } = useApi<User>();
    const user = ref<User | null>(null);
    const isAuthenticated = ref(false);

    const login = async (email: string, password: string) => {
        const response = await postData(API_ENDPOINTS.AUTH + '/login', {
            email,
            password,
        });

        if (response) {
            const { token, user: userData } = response as any;
            localStorage.setItem('token', token);
            user.value = userData;
            isAuthenticated.value = true;
            router.push('/dashboard');
            return true;
        }

        return false;
    };

    const logout = () => {
        localStorage.removeItem('token');
        user.value = null;
        isAuthenticated.value = false;
        router.push('/login');
    };

    const checkAuth = async () => {
        const token = localStorage.getItem('token');
        if (!token) {
            isAuthenticated.value = false;
            return false;
        }

        try {
            const response = await postData(API_ENDPOINTS.AUTH + '/me', {});
            if (response) {
                user.value = response;
                isAuthenticated.value = true;
                return true;
            }
        } catch (err) {
            logout();
        }

        return false;
    };

    return {
        user,
        loading,
        error,
        isAuthenticated,
        login,
        logout,
        checkAuth,
    };
} 