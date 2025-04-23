import { defineStore, acceptHMRUpdate } from "pinia";
import { useStorage } from "@vueuse/core";
import { usePage, router } from "@inertiajs/vue3";
import {
    menus as menuFn,
    rapidLinks as impRapidLinks,
} from "@/config/sidebarMenu";
import type { Menu, Item, RapidLink } from "@/types";
import { ref, Ref, toValue } from "vue";

export const useSidebarStore = defineStore("sidebar", () => {
    const page = usePage();

    const isOpen = ref(false);
    const selectedMenu = useStorage<string>("selectedMenu", "Accueil");

    const menus: Ref<Menu[]> = ref(
        menuFn((page.props as any).routePrefix).map((menu) => ({
            ...menu,
            selected: ref(0),
        })),
    );

    const rapidLinks: Ref<RapidLink[]> = ref(impRapidLinks);

    const getMenu = (search: string | number): Menu | null => {
        return (
            menus.value.find((menu, index) =>
                typeof search === "number"
                    ? index === search
                    : menu.title === search,
            ) || null
        );
    };

    const getIndex = (items: Item[], name: string): number | null => {
        const index = items.findIndex((item) => item.name === name);
        if (index !== -1) return index;

        for (let i = 0; i < items.length; i++) {
            const children = items[i].children || [];
            const childIndex = getIndex(children, name);
            if (childIndex !== null) return childIndex;
        }

        return null;
    };

    const setSelected = (
        menuSearch: string | number,
        itemSearch: string | number,
        childSearch: string | number = "",
    ) => {
        const menu = getMenu(menuSearch);
        if (!menu) return;

        var index =
            typeof itemSearch === "number"
                ? itemSearch
                : getIndex(menu.items || [], itemSearch);

        if (childSearch != "") {
            index =
                typeof childSearch === "number"
                    ? childSearch
                    : getIndex(menu.items[index]?.children || [], childSearch);
            return;
        }

        if (!route().current(menu.route)) {
            router.visit(route(menu.route));
        }

        selectedMenu.value = menu.title;
        menu.selected = index || 0;
    };

    const isActive = (menu: Menu): boolean => {
        return route().current(menu.route) && selectedMenu.value === menu.title;
    };

    const searchMenu = (search = ""): Menu[] => {
        return menus.value.filter((menu) => {
            return (
                menu.title.toLowerCase().includes(search.toLowerCase()) ||
                menu.items?.some(
                    (item) =>
                        item.name
                            .toLowerCase()
                            .includes(search.toLowerCase()) ||
                        item.children?.some((child) =>
                            child.name
                                .toLowerCase()
                                .includes(search.toLowerCase()),
                        ),
                )
            );
        });
    };

    const currentMenu = (): Menu | null => {
        return (
            menus.value.find((menu) => menu.title === selectedMenu.value) ||
            null
        );
    };

    const currentComponent = (name = ""): any => {
        try {
            const menu = currentMenu();
            if (!menu) return null;

            let component: any = null;

            menu.items?.forEach((item, index) => {
                if (item.name === name || toValue(menu.selected) === index) {
                    component = item.component;
                }

                item.children?.forEach((child, childIndex) => {
                    if (
                        child.name === name ||
                        toValue(menu.selected) === childIndex
                    ) {
                        component = child.component;
                    }
                });
            });

            return component;
        } catch (error) {
            console.error("Erreur dans currentComponent:", error);
            return null;
        }
    };

    /**
     * @deprecated Use `menus.value` directly instead.
     */
    const getMenus = (): Menu[] => {
        return menus.value.map((menu) => {
            const newMenu = { ...menu };

            if (newMenu.items) {
                newMenu.items = newMenu.items.map((item) => {
                    const newItem = { ...item };

                    if (newItem.children) {
                        newItem.children = newItem.children.map((child) => ({
                            ...child,
                            action: () =>
                                setSelected(newMenu.title, child.name),
                        }));
                    } else {
                        newItem.action = () =>
                            setSelected(newMenu.title, newItem.name);
                    }

                    return newItem;
                });
            } else {
                newMenu.action = () => setSelected(newMenu.title, 0);
            }

            return newMenu;
        });
    };

    return {
        isOpen,
        selectedMenu,
        rapidLinks,
        menus,
        getMenu,
        getMenus,
        getIndex,
        setSelected,
        isActive,
        currentMenu,
        currentComponent,
        searchMenu,
    };
});
