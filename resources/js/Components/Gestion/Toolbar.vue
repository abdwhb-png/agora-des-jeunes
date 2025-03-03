<script setup>
import { useMainStore } from "@/stores/main";
import Breadcrumb from "./Breadcrumb.vue";
import RapidLinks from "./RapidLinks.vue";
import Rapports from "./Rapports.vue";
import DropdownNotification from "@/Components/Base/DropdownNotification.vue";
import { useResponsive } from "@/composables/useResponsive";

defineProps({
    title: String,
});

const desktopMode = useResponsive("up", "lg");

const mainStore = useMainStore();
</script>

<style>
.topbar-sticky {
    -webkit-backdrop-filter: blur(8px);
    backdrop-filter: blur(8px);
    background-color: var(--topbar-sticky-background, hsla(0, 0%, 92%, 0.7));
}
</style>

<template>
    <!-- Toolbar -->
    <div class="pb-5 md:sticky md:top-0 md:px-2 z-10">
        <!-- Container -->
        <div
            class="container-fluid flex justify-center md:justify-between items-center flex-wrap gap-3 md:p-1.5"
            :class="[
                {
                    'topbar-sticky rounded-lg':
                        mainStore.isScrolled && desktopMode,
                },
            ]"
        >
            <!-- Breadcrumb -->
            <Breadcrumb :title="title" />
            <!-- End of Breadcrumb -->

            <div
                class="flex items-center justify-center flex-wrap gap-1.5 lg:gap-3.5"
            >
                <button
                    class="btn btn-icon btn-icon-lg size-9 rounded-md hover:bg-gray-200 dropdown-open:bg-gray-200 hover:text-primary text-gray-600"
                    data-modal-toggle="#search_modal"
                >
                    <i class="ki-filled ki-magnifier"> </i>
                </button>
                <DropdownNotification />
                <RapidLinks />
                <Rapports />
            </div>
        </div>
        <!-- End of Container -->
    </div>
    <!-- End of Toolbar -->
</template>
