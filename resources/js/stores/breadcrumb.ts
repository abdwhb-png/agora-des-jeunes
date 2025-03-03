import { defineStore, acceptHMRUpdate } from "pinia";
import { Item, Menu } from "@/types/sidebar";

interface Breadcrumb {
    name: string;
    menu?: Menu;
    route?: string;
}

export const useBreadcrumbStore = defineStore("breadcrumb", {
    state: () => ({
        breadcrumb: [],
    }),

    getters: {
        generateBreadcrumb: (state) => {
            return (sidebarStore: AnimationPlaybackEventInit): Breadcrumb[] => {
                const breadcrumb = [];
                const menu = sidebarStore?.currentMenu || null;

                if (menu) {
                    if (menu.title != "Accueil") {
                        breadcrumb.push({
                            name: menu.title,
                            route: menu.route,
                        });
                    }

                    menu.items?.forEach((item: Item) => {
                        let name = "";
                        const index = sidebarStore.getIndex(
                            menu.items,
                            item.name,
                        );
                        if (index === menu.selected) {
                            name = item.name;
                        }

                        if (item.children) {
                            const foundChild = item.children.find(
                                (child: Item) => child.name === menu.selected,
                            );
                            const index = state.getIndex(
                                item.children,
                                foundChild?.name,
                            );
                            if (menu.selected === index) {
                                name = foundChild.name;
                            }
                        }

                        if (name) {
                            breadcrumb.push({
                                menu: menu,
                                name: name,
                            });
                        }
                    });
                } else {
                    breadcrumb.push({
                        name: "Page: " + route().current(),
                        route: route().current(),
                    });
                }

                return breadcrumb;
            };
        },
    },

    actions: {
        updateBreadcrumb() {
            this.breadcrumb = this.generateBreadcrumb();
        },
    },
});

if (import.meta.hot) {
    import.meta.hot.accept(
        acceptHMRUpdate(useBreadcrumbStore, import.meta.hot),
    );
}
