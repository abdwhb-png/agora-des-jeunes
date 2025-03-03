<script setup lang="ts">
import { router } from "@inertiajs/vue3";
import { ref, onMounted, nextTick, computed } from "vue";
import { useSidebarStore } from "@/stores/sidebar";
import { useUserStore } from "@/stores/user";
import { useViewport } from "@/composables/useViewport";
import { useResponsive } from "@/composables/useResponsive";
import { getHeight } from "@/utils/helpers";
import { Menu } from "@/types/sidebar";

import MenuElement from "./Sidebar/MenuElement.vue";
import DropdownUser from "@/Components/Base/DropdownUser.vue";
import DropdownSetting from "@/Components/Base/DropdownSetting.vue";

const sidebarStore = useSidebarStore();
const userStore = useUserStore();

const desktopMode = useResponsive("up", "lg");
const mobileMode = useResponsive("down", "lg");

const sidebarRef = ref();
const headerRef = ref();
const footerRef = ref();

const scrollableHeight = ref(589);
const { height: viewportHeight, isMobile } = useViewport();

const showMenu = (name: string) =>
    computed(() => {
        switch (name.toLowerCase()) {
            case "roles":
                return userStore.hasPermission("view_roles");
            case "permissions":
                return userStore.hasPermission("view_permissions");
            case "configuration":
                return userStore.hasPermission("manage_configuration");
            case "config. api":
                return userStore.hasPermission("access_internal_api");
            default:
                return true;
        }
    });

onMounted(async () => {
    nextTick(() => {
        if (isMobile) {
            closeMobileSidebar();
        } else {
            updateScrollableHeight();
        }
    });

    await userStore.fetchPermissions();
    await userStore.fetchRoles();
});

function updateScrollableHeight() {
    const headerHeight = headerRef.value ? getHeight(headerRef.value) : 0;
    const footerHeight = footerRef.value ? getHeight(footerRef.value) : 0;
    scrollableHeight.value =
        viewportHeight.value - headerHeight - footerHeight - 40;
}

function closeMobileSidebar() {
    const drawer = KTDrawer.getInstance(sidebarRef.value);

    if (drawer) {
        drawer.hide();
    }
}
</script>

<template>
    <div
        class="fixed top-0 bottom-0 z-20 rounded-r-lg md:rounded-none outline-2 md:outline-0 hidden lg:flex flex-col items-stretch shrink-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]"
        data-drawer="true"
        data-drawer-class="drawer drawer-start flex"
        data-drawer-enable="true|lg:false"
        data-drawer-backdrop-static="false"
        data-drawer-persistent="false"
        ref="sidebarRef"
        id="sidebar"
    >
        <!-- logo -->
        <div
            v-if="desktopMode"
            ref="headerRef"
            class="hidden lg:flex items-center justify-center shrink-0 pt-8 pb-3.5"
            id="sidebar_header"
        >
            <a href="/">
                <img
                    class="dark:hidden min-w-[30px] max-w-[40px]"
                    src="/images/favicon.png"
                />
                <img
                    class="hidden dark:block min-x-[30px] max-w-[40px]"
                    src="/images/favicon.png"
                />
            </a>
        </div>
        <!-- End of logo -->

        <div
            class="scrollable-y-hover grow gap-2.5 shrink-0 flex items-center pt-5 lg:pt-0 ps-3 pe-3 lg:pe-0 flex-col"
            :style="{ height: scrollableHeight + 'px' }"
            data-scrollable="true"
            data-scrollable-dependencies="#sidebar_header,#sidebar_footer"
            data-scrollable-height="auto"
            data-scrollable-offset="80px"
            data-scrollable-wrappers="#sidebar_menu_wrapper"
            id="sidebar_menu_wrapper"
        >
            <!-- Sidebar Menu -->
            <div
                class="menu flex flex-col gap-2.5 grow"
                data-menu="true"
                id="sidebar_menu"
            >
                <template
                    v-for="(menu, index) in sidebarStore.menus"
                    :key="index"
                >
                    <MenuElement
                        v-if="showMenu(menu.title).value"
                        :menu="menu"
                    />
                </template>
            </div>
            <!-- End of Sidebar Menu -->
        </div>

        <div
            ref="footerRef"
            class="flex flex-col gap-5 items-center shrink-0 pb-4"
        >
            <div class="flex flex-col gap-1.5">
                <!-- Dropdown Chat -->
                <!-- <DropdownChat /> -->
                <!-- End of Dropdown Chat -->

                <!-- Dropdown Setting -->
                <DropdownSetting />
                <!-- End of Dropdown Setting -->
            </div>
            <!-- Dropdown User -->
            <DropdownUser
                data-menu-item-offset="-20px, 28px"
                data-menu-item-overflow="true"
                data-menu-item-placement="right-end"
                data-menu-item-toggle="dropdown"
                data-menu-item-trigger="click|lg:click"
                :rounded="false"
                img-size="size-10"
            />
            <!-- End of Dropdown User -->
        </div>
    </div>
</template>
