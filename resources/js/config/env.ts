interface EnvConfig {
    VITE_API_URL: string;
    VITE_APP_NAME: string;
    VITE_APP_ENV: 'development' | 'production' | 'testing';
    VITE_APP_DEBUG: boolean;
}

const env: EnvConfig = {
    VITE_API_URL: import.meta.env.VITE_API_URL || 'http://localhost:8000',
    VITE_APP_NAME: import.meta.env.VITE_APP_NAME || 'Agora Jeunes',
    VITE_APP_ENV: (import.meta.env.VITE_APP_ENV as EnvConfig['VITE_APP_ENV']) || 'development',
    VITE_APP_DEBUG: import.meta.env.VITE_APP_DEBUG === 'true',
};

export default env; 