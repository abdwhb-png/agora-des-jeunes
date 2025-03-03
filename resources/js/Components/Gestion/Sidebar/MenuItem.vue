<script setup lang="ts">
import { useSidebarStore } from "@/stores/sidebar";
import { Item, Menu } from "@/types/sidebar";

defineProps({
    item: { type: Object as () => Item, required: true },
    menu: { type: Object as () => Menu, required: true },
    isActive: Boolean,
});

const sidebarStore = useSidebarStore();
</script>

<template>
    <div
        v-if="!item.children"
        class="menu-item"
        :class="{
            here: isActive,
        }"
    >
        <a
            class="menu-link"
            href="#"
            @click="sidebarStore.setSelected(menu.title, item.name)"
        >
            <span class="menu-title"> {{ item.name }} </span>
        </a>
    </div>
    <div
        v-else
        class="menu-item menu-item-dropdown"
        :class="{
            here: isActive,
        }"
        data-menu-item-placement="right-start"
        data-menu-item-toggle="accordion|lg:dropdown"
        data-menu-item-trigger="click|lg:hover"
    >
        <div class="menu-link grow cursor-pointer">
            <span class="menu-title"> {{ item.name }} </span>
            <span class="menu-arrow">
                <i
                    class="ki-filled ki-right text-3xs rtl:translate rtl:rotate-180"
                >
                </i>
            </span>
        </div>
        <div class="menu-default menu-dropdown gap-0.5 w-[220px]">
            <div
                v-for="(child, index) in item.children"
                :key="child.name"
                class="menu-item"
            >
                <a
                    class="menu-link"
                    href="#"
                    @click="sidebarStore.setSelected(menu.title, item.name)"
                >
                    <span class="menu-title"> {{ child.name }} </span>
                </a>
            </div>
        </div>
    </div>
</template>
