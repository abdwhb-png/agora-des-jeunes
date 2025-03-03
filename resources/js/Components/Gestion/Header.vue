<template>
    <header
        class="flex lg:hidden items-center fixed z-10 top-0 start-0 end-0 shrink-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark] h-[--tw-header-height]"
        id="header"
    >
        <!-- Container -->
        <div
            class="container-fixed flex items-center justify-between flex-wrap gap-3"
        >
            <a href="/">
                <Logo class="dark:hidden h-10" />
                <Logo class="hidden dark:block h-10" />
            </a>
            <button
                class="btn btn-icon btn-light btn-clear btn-sm -me-2"
                data-drawer-toggle="#sidebar"
                @click="sidebarStore.isOpen = !sidebarStore.isOpen"
            >
                <i class="ki-filled ki-menu"> </i>
            </button>
        </div>
        <!-- End of Container -->
    </header>
</template>

<script setup>
import { useSidebarStore } from "@/stores/sidebar";
import Logo from "@/Components/Logo.vue";

const sidebarStore = useSidebarStore();
</script>
