<script setup>
import { useSidebarStore } from "@/stores/sidebar";

const sidebarStore = useSidebarStore();
</script>

<template>
    <!-- Dropdown -->
    <div class="menu menu-default p-0 px-2" data-menu="true">
        <div
            class="menu-item w-full px-0.5 menu-item-dropdown"
            data-menu-item-offset="-4px, 0"
            data-menu-item-placement="top-start"
            data-menu-item-toggle="dropdown"
            data-menu-item-trigger="hover"
        >
            <button
                class="menu-toggle w-full btn btn-light btn-sm justify-between flex-nowrap"
            >
                <span class="flex items-center gap-1.5">
                    <i class="pi pi-external-link !text-md"> </i>
                    Liens Rapides
                </span>
                <span class="flex items-center lg:ms-4">
                    <i class="ki-filled ki-down !text-xs"> </i>
                </span>
            </button>
            <div class="menu-dropdown w-[170px] py-2" style="">
                <div
                    v-for="(item, index) in sidebarStore.rapidLinks"
                    :key="item.label"
                    class="menu-item"
                    :class="{
                        active: item.route && route().current(item.route),
                    }"
                >
                    <a
                        class="menu-link"
                        :href="item.url ?? route(item.route)"
                        :target="item.url ? '_blank' : '_self'"
                    >
                        <span class="menu-icon">
                            <i :class="item.icon"> </i>
                        </span>
                        <span class="menu-title"> {{ item.label }} </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Dropdown -->
</template>
