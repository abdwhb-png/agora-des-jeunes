import { Role, Permission } from "./roles-perms";

export interface User {
    id: number;
    email: string;
    phone: string;
    info: Object;
    account: Object;
    roles: Role[];
    permissions: Permission[];
    // role: UserRole;
    created_at: string;
    updated_at: string;
}

export enum UserRole {
    ADMIN = "admin",
    EDITOR = "editor",
    USER = "user",
}

export interface UserPreferences {
    theme: "light" | "dark";
    language: string;
    notifications: boolean;
}
