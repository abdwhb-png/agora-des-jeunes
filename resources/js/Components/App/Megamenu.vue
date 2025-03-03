<script setup lang="ts">
import { ref } from "vue";
import { useStorage } from "@vueuse/core";
import { usePage } from "@inertiajs/vue3";
import MegamenuHelp from "./MegamenuHelp.vue";

interface Item {
    title: string;
    url?: string;
    route?: string;
    target?: string;
}

const page = usePage();

const active = useStorage("megamenu_active", null);

const items: Item[] = [
    {
        title: "Accueil",
        url: page.props.app.url,
        target: "_blank",
    },
    {
        title: "Profil",
        route: "profil",
    },
    {
        title: "Compte",
        route: "account",
    },
];

const setActive = (title: string) => {
    active.value = title;
};
</script>

<template>
    <div
        class="hidden lg:flex lg:items-stretch"
        data-drawer="true"
        data-drawer-class="drawer drawer-start fixed z-10 top-0 bottom-0 w-full me-5 max-w-[250px] p-5 lg:p-0 overflow-auto"
        data-drawer-enable="true|lg:false"
        id="mega_menu_wrapper"
    >
        <!--Megamenu-->
        <div
            class="menu flex-col lg:flex-row gap-5 lg:gap-7.5"
            data-menu="true"
            id="mega_menu"
        >
            <!--Megamenu Item-->
            <template v-for="(item, index) in items" :key="item.title">
                <div
                    class="menu-item"
                    @click="setActive(item.title)"
                    :class="{
                        active: item.route && route().current(item.route),
                    }"
                >
                    <a
                        class="menu-link text-nowrap text-sm text-gray-700 font-medium hover:text-primary menu-item-active:text-gray-900 menu-item-active:font-medium"
                        :href="item.url || route(item.route)"
                        :target="item.target || '_self'"
                    >
                        <span class="menu-title text-nowrap">
                            {{ item.title }}
                        </span>
                    </a>
                </div>
            </template>
            <!--End of Megamenu Item-->
            <!--Megamenu Item-->
            <MegamenuHelp />
            <!-- End of Megamenu Item    -->
        </div>
        <!--End of Megamenu-->
    </div>
</template>
