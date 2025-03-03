<script setup>
import { ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import { useBodyClasses } from "@/composables/useBodyClasses";

import Sidebar from "@/Components/App/Sidebar.vue";
import Header from "@/Components/App/Header.vue";
import Footer from "@/Components/Base/Footer.vue";
import Breadcrumb from "@/Components/App/Breadcrumb.vue";

defineProps({
    title: String,
    description: String,
});

useBodyClasses(`
    [--tw-page-bg:#fff7ed]
    [--tw-page-bg-dark:var(--tw-coal-500)]
    demo1
    sidebar-fixed
    header-fixed
    bg-[--tw-page-bg]
    dark:bg-[--tw-page-bg-dark]
  `);
</script>

<template>
    <Head :title="title + ' (App)'" />
    <!-- Sidebar -->
    <Sidebar />
    <!-- End of Sidebar -->

    <!-- Wrapper -->
    <div class="wrapper flex grow flex-col">
        <!-- Header -->
        <Header />
        <!-- End of Header -->

        <!-- Content -->
        <div class="grow content pt-5" id="content" role="content">
            <!-- Container -->
            <div class="container-fixed" id="content_container"></div>
            <!-- End of Container -->

            <!-- Breadcrumb -->
            <slot name="topContainer">
                <Breadcrumb :title="title" :description="description" />
            </slot>
            <!-- End of Breadcrumb -->

            <!-- Main Container -->
            <div class="container-fixed">
                <slot> </slot>
            </div>
            <!-- End of Main Container -->
        </div>
        <!-- End of Content -->

        <!-- Footer -->
        <Footer />
        <!-- End of Footer -->
    </div>
    <!-- End of Wrapper -->
</template>
