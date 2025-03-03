import { DefineComponent, Raw } from "vue";

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

export interface User {
    id: number;
    email: string;
    info: Object;
    account: Object;
    roles: Role[];
    permissions: Permission[];
}

export interface LaravelPagination<T> {
    current_page: number;
    data: T[];
    first_page_url: string;
    from: number | null;
    last_page: number;
    last_page_url: string;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number | null;
    total: number;
}

export interface CustomPaginatedData {
    list: LaravelPagination<any>;
    filter_name: String;
}

export interface ModalTab {
    title: string;
    content: Raw<DefineComponent> | String;
    props?: Object;
}

export interface IScrollSpyProps {
    children?: any; // Vue uses slots instead of `children`
    targetRef?: HTMLElement | Document | null;
    onUpdate?: (id: string) => void;
    offset?: number;
    smooth?: boolean;
    className?: string;
    dataAttribute?: string;
    activeClass?: string;
    history?: boolean;
    throttleTime?: number;
}

export interface IScrollspyMenuItem {
    title: string;
    target?: string;
    active?: boolean;
    children?: IScrollspyMenuItem[];
}

export type IScrollspyMenuItems = IScrollspyMenuItem[];
