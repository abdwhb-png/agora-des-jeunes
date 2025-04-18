import { RemovableRef } from "@vueuse/core";

export interface Item {
    name: string;
    description?: string;
    component?: any;
    icon?: string;
    children?: Item[];
    action?: Function;
}

export interface Menu {
    title: string;
    description?: string;
    route: string;
    icon: string;
    items?: Item[];
    selected?: number | RemovableRef<number>;
    hide?: boolean;
    action?: Function;
}

export interface RapidLink {
    label: string;
    url?: string;
    route?: string;
    icon: string;
}
