<template>
    <Head>
        <link href="/static/css/styles.css" rel="stylesheet" />
    </Head>

    <Loader v-if="!mainStore.showContent" />

    <div v-else class="flex grow">
        <GestionLayout
            :title="title"
            v-if="$page.props.routePrefix === 'gestion.'"
        >
            <slot></slot>
        </GestionLayout>

        <AppLayout :title="title" v-else>
            <slot></slot>
        </AppLayout>
    </div>

    <SearchModal />

    <Toast />
    <Toaster />
    <ConfirmDialog />
    <ScrollTop />
</template>

<script setup>
import { onMounted, onUnmounted, ref, nextTick } from "vue";
import { useMainStore } from "@/stores/main";
import { useUserStore } from "@/stores/user";
import KTComponent from "@metronic/core/index.spa";
import KTLayout from "@metronic/app/layouts/demo1.js";

import AppLayout from "./AppLayout.vue";
import GestionLayout from "./GestionLayout.vue";
import SearchModal from "@/Components/Modals/SearchModal.vue";
import Toaster from "@/Components/ui/toast/Toaster.vue";
import { usePage } from "@inertiajs/vue3";
import { useBodyClasses } from "@/composables/useBodyClasses";

defineProps({
    title: String,
});

const page = usePage();
const mainStore = useMainStore();
const userStore = useUserStore();

const scrollable = ref(null);

useBodyClasses(`antialiased flex h-full text-base text-gray-700`);

onMounted(() => {
    if (page.props.auth.auth_token) {
        localStorage.setItem("auth_token", page.props.auth.auth_token);
    } else {
        localStorage.removeItem("auth_token");
    }
    userStore.fetchUser();

    nextTick(() => {
        KTComponent.init();
        KTLayout.init();
        KTTogglePassword.init();

        window.addEventListener("load", mainStore.setShowContent(true), false);
        scrollable.value = document.getElementById("scrollable_content");
        scrollable.value?.addEventListener("scroll", mainStore.handleScroll);
    });
});

onUnmounted(() => {
    scrollable.value?.removeEventListener("scroll", mainStore.handleScroll);
    window.removeEventListener("load", mainStore.setShowContent(true));
});
</script>
