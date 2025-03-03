<script setup lang="ts">
import { router } from "@inertiajs/vue3";
import { useSidebarStore } from "@/stores/sidebar";
import { Menu } from "@/types/sidebar";
import MenuItem from "./MenuItem.vue";

defineProps({
    menu: { type: Object as () => Menu, required: true },
});

const sidebarStore = useSidebarStore();

const menuContent = (menu: Menu) => {
    return `
    <span
                class="menu-icon menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600"
            >
                <i class="ki-filled text-1.5xl ${menu.icon}"></i>
            </span>
            <span
                class="text-center menu-title text-xs menu-item-here:text-primary menu-item-active:text-primary menu-link-hover:text-primary text-gray-600 font-medium"
            >
                ${menu.title}
            </span>
    `;
};
</script>

<template>
    <div
        v-if="!menu.items"
        class="menu-item"
        :class="{
            active: route().current(menu.route),
        }"
    >
        <a
            class="menu-link rounded-[9px] border border-transparent menu-item-active:border-gray-200 menu-item-active:bg-light menu-link-hover:bg-light menu-link-hover:border-gray-200 w-[80px] h-[60px] flex flex-col justify-center items-center gap-1 p-2"
            href="#"
            @click="sidebarStore.setSelected(menu.title, 0)"
            v-html="menuContent(menu)"
        >
        </a>
    </div>
    <div
        v-else
        class="menu-item"
        :class="{
            here: sidebarStore.isActive(menu),
        }"
        data-menu-item-offset="-10px, 14px"
        data-menu-item-overflow="true"
        data-menu-item-placement="right-start"
        data-menu-item-toggle="dropdown"
        data-menu-item-trigger="click|lg:hover"
    >
        <div
            class="menu-link rounded-[9px] border border-transparent menu-item-here:border-gray-200 menu-item-here:bg-light menu-link-hover:bg-light menu-link-hover:border-gray-200 w-[80px] h-[60px] flex flex-col justify-center items-center gap-1 p-2 grow"
            v-html="menuContent(menu)"
        ></div>

        <div
            class="menu-default menu-dropdown gap-0.5 w-[220px] scrollable-y-auto lg:overflow-visible max-h-[50vh]"
            style=""
        >
            <template v-for="(item, itemIndex) in menu.items" :key="item.name">
                <MenuItem
                    :menu="menu"
                    :item="item"
                    :isActive="
                        sidebarStore.isActive(menu) &&
                        sidebarStore.currentMenu?.selected === itemIndex
                    "
                />
            </template>
        </div>
    </div>
</template>
