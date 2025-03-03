<script setup>
import { useSidebarStore } from "@/stores/sidebar";
import DashSide from "./Partials/DashSide.vue";

const sidebarStore = useSidebarStore();
</script>

<template>
    <MainLayout title="Tableau de bord">
        <div class="grid gap-5 xl:gap-7.5">
            <div class="grid xl:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
                <div class="xl:col-span-2">
                    <component :is="sidebarStore.currentComponent()" />
                </div>
                <div class="xl:col-span-1">
                    <DashSide />
                </div>
            </div>
        </div>
    </MainLayout>
</template>
