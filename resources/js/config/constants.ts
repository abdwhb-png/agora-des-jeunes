export const APP_NAME = 'Agora Jeunes';

export const API_ENDPOINTS = {
    AUTH: '/api/auth',
    USERS: '/api/users',
    POSTS: '/api/posts',
    COLLECTIONS: '/api/collections',
} as const;

export const DATE_FORMAT = 'DD/MM/YYYY';
export const DATETIME_FORMAT = 'DD/MM/YYYY HH:mm';

export const PAGINATION = {
    DEFAULT_PER_PAGE: 10,
    MAX_PER_PAGE: 100,
} as const;

export const FILE_UPLOAD = {
    MAX_SIZE: 5 * 1024 * 1024, // 5MB
    ALLOWED_TYPES: ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'],
} as const; 