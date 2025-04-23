export interface Role {
    id: number;
    name: string;
    permissions?: Permission[];
    loading?: boolean;
}

export interface Permission {
    id: number;
    name: string;
    roles?: Role[];
    loading?: boolean;
}
