import { defineStore, acceptHMRUpdate } from "pinia";
import { useStorage } from "@vueuse/core";
import { usePage, router } from "@inertiajs/vue3";
import { menus, rapidLinlks } from "@/config/sidebarMenu";
import { Menu, Item } from "@/types/sidebar";

const page = usePage();

export const useSidebarStore = defineStore("sidebar", {
    state: () => ({
        isOpen: false,
        selectedMenu: useStorage("selectedMenu", "Accueil"),
        rapidLinks: rapidLinlks,
        menus: menus((page.props as any).routePrefix),
    }),

    getters: {
        getMenus: (state) => {
            return (search: string = "") => {
                return state.menus.filter((menu: Menu) => {
                    return (
                        menu.title
                            .toLowerCase()
                            .includes(search.toLowerCase()) ||
                        menu.items?.some((item: Item) =>
                            item.name
                                .toLowerCase()
                                .includes(search.toLowerCase()),
                        )
                    );
                });
            };
        },

        getIndex: (state) => {
            return (items: Item[], itemName: string): number | null => {
                // Chercher l'index dans les items principaux
                let index = items.findIndex((item) => item.name === itemName);
                if (index !== -1) return index;

                // Chercher l'index dans les sous-éléments (children)
                for (let i = 0; i < items.length; i++) {
                    if (items[i].children) {
                        let childIndex = items[i].children.findIndex(
                            (child) => child.name === itemName,
                        );
                        if (childIndex !== -1) return childIndex;
                    }
                }

                return null;
            };
        },

        currentMenu: (state): Menu | null => {
            const menu = state.menus.find((menu: Menu) => {
                return menu.title === state.selectedMenu;
            });

            return menu || null;
        },

        currentComponent:
            (state) =>
            (name = ""): any => {
                try {
                    const menu = state.currentMenu;
                    if (!menu) return null;

                    let component = null;

                    // Parcourir les éléments du menu
                    menu.items?.forEach((item: Item, index: number) => {
                        // Vérifier si l'élément actuel correspond directement au nom recherché
                        if (item.name === name || menu.selected === index) {
                            component = item.component || null;
                        }

                        // Vérifier si l'élément a des sous-éléments (children)
                        item.children?.forEach(
                            (child: Item, childIndex: number) => {
                                if (
                                    child.name === name ||
                                    menu.selected === childIndex
                                ) {
                                    component = child.component || null;
                                }
                            },
                        );
                    });

                    return component;
                } catch (error) {
                    console.error("Erreur dans currentComponent:", error);
                    return null;
                }
            },

        getMenu:
            (state) =>
            (search: string | number): Menu | null => {
                const menu = state.menus.find((menu: Menu, index: number) =>
                    typeof search === "number"
                        ? index === search
                        : menu.title === search,
                );

                return menu || null;
            },
    },

    actions: {
        isActive(menu: Menu) {
            return (
                route().current(menu.route) && this.selectedMenu === menu.title
            );
        },
        setSelected(menuSearch: string | number, itemSearch: string | number) {
            const menu = this.getMenu(menuSearch);

            if (menu) {
                const index =
                    typeof itemSearch === "number"
                        ? itemSearch
                        : this.getIndex(menu.items, itemSearch);

                if (!route().current(menu.route)) {
                    router.visit(route(menu.route));
                }

                this.selectedMenu = menu.title;
                menu.selected = index || 0;
            }
        },
    },
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useSidebarStore, import.meta.hot));
}
