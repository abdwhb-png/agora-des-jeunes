import { RemovableRef } from "@vueuse/core";

export interface Item {
    name: string;
    component?: any;
    icon?: string;
    children?: Item[];
}

export interface Menu {
    title: string;
    route: string;
    icon: string;
    items?: Item[];
    selected?: RemovableRef<number>;
    hide?: boolean;
}

export interface RapidLink {
    label: string;
    url?: string;
    route?: string;
    icon: string;
}
