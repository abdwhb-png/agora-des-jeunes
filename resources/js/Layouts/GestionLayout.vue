<!-- resources/js/Layouts/GestionLayout.vue -->
<script setup>
import { router } from "@inertiajs/vue3";
import { updatePreset } from "@primeuix/themes";
import { getPreset } from "@/config/primePreset";
import { ref, onBeforeMount, onMounted, watch, onUnmounted } from "vue";
import { useBodyClasses } from "@/composables/useBodyClasses";
import { useViewport } from "@/composables/useViewport";
import { useMainStore } from "@/stores/main";
import { useSidebarStore } from "@/stores/sidebar";

import Header from "@/Components/Gestion/Header.vue";
import Sidebar from "@/Components/Gestion/Sidebar.vue";
import Toolbar from "@/Components/Gestion/Toolbar.vue";
import Footer from "@/Components/Base/Footer.vue";
import NoContentCard from "@/Components/Base/NoContentCard.vue";

defineProps({
    title: String,
});

const mainStore = useMainStore();
const sidebarStore = useSidebarStore();

const { width: viewportWidth } = useViewport();
const noContent = ref(false);

useBodyClasses(`
    [--tw-page-bg:#F6F6F9]
    [--tw-page-bg-dark:var(--tw-coal-200)]
    [--tw-content-bg:var(--tw-light)]
    [--tw-content-bg-dark:var(--tw-coal-500)]
    [--tw-content-scrollbar-color:#e8e8e8]
    [--tw-header-height:60px]
    [--tw-sidebar-width:105px]
    bg-[--tw-page-bg]
    dark:bg-[--tw-page-bg-dark]
  `);

const isRapidLink = () => {
    return sidebarStore.rapidLinks?.find(
        (link) => link.route && route().current(link.route),
    );
};

function setDefaultMenu() {
    sidebarStore.menus.forEach((menu, index) => {
        if (route().current(menu.route)) {
            sidebarStore.selectedMenu = menu.title;
        }
    });
}

onBeforeMount(() => {
    setDefaultMenu();
    updatePreset(getPreset("gestion"));
});

onMounted(() => {
    router.on("start", (event) => {
        if (event.detail.visit.method.toLowerCase() === "get")
            mainStore.showContent = false;
    });

    router.on("finish", (event) => {
        setDefaultMenu();
        mainStore.showContent = true;
    });
});

onUnmounted(() => {
    // mainStore.showContent = false;
});

watch(
    () => (sidebarStore.currentMenu, sidebarStore.currentComponent),
    (currentMenu, currentComponent) => {
        if (!currentMenu || !currentComponent) {
            noContent.value = true;
        } else {
            noContent.value = false;
        }
    },
    { deep: true },
);
</script>

<template>
    <Head :title="title + ' (Gestion)'">
        <!-- <link href="/static/css/styles.css" rel="stylesheet" /> -->
    </Head>
    <!-- Header -->
    <Header :style="{ maxWidth: viewportWidth + 'px' }" />
    <!-- End of Header -->
    <!-- Wrapper -->
    <div class="flex flex-col lg:flex-row grow pt-[--tw-header-height] lg:pt-0">
        <!-- Sidebar -->
        <Sidebar />
        <!-- End of Sidebar -->

        <!-- Main -->
        <p class="min-h-[2px]"></p>
        <div
            class="flex flex-col grow rounded-xl bg-[--tw-content-bg] dark:bg-[--tw-content-bg-dark] border border-gray-300 dark:border-gray-200 lg:ms-[--tw-sidebar-width] mt-0 lg:mt-5 m-5"
        >
            <div
                class="flex flex-col grow lg:scrollable-y-auto lg:[scrollbar-width:auto] lg:light:[--tw-scrollbar-thumb-color:var(--tw-content-scrollbar-color)] pt-5"
                id="scrollable_content"
            >
                <main class="grow pb-3" role="content">
                    <Toolbar :title />
                    <!-- Container -->
                    <div class="container-fluid xxl:container-fixed">
                        <div class="xl:px-[70px]">
                            <NoContentCard v-if="noContent" />
                            <slot v-else />
                        </div>
                    </div>
                    <!-- End of Container -->
                </main>
            </div>
            <Divider />
            <!-- Footer -->
            <Footer />
            <!-- End of Footer -->
        </div>
        <p class="min-h-[2px]"></p>
        <!-- End of Main -->
    </div>
    <!-- End of Wrapper -->
</template>
