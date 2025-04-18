export interface User {
    id: number;
    name: string;
    email: string;
    role: UserRole;
    created_at: string;
    updated_at: string;
}

export enum UserRole {
    ADMIN = 'admin',
    EDITOR = 'editor',
    USER = 'user',
}

export interface UserPreferences {
    theme: 'light' | 'dark';
    language: string;
    notifications: boolean;
} 