<template>
    <div class="flex justify-center items-center min-h-[500px]">
        <Card>
            <template #content>
                <div class="text-center">
                    <h3 class="text-2xl mb-3">
                        Cette page est actuellement indisponible !
                    </h3>
                    <div class="flex flex-wrap justify-center gap-3">
                        <Button
                            v-if="sidebarStore.currentMenu"
                            @click="
                                sidebarStore.setSelected(
                                    sidebarStore.currentMenu.title,
                                    sidebarStore.currentMenu.selected,
                                )
                            "
                            raised
                            label="Actualier"
                            icon="ki-filled ki-arrow-circle-right"
                        />
                        <Button
                            @click="home"
                            raised
                            severity="secondary"
                            label="Tableau de bord"
                            icon="ki-filled ki-home"
                        />
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { useSidebarStore } from "@/stores/sidebar";
import { router } from "@inertiajs/vue3";

const sidebarStore = useSidebarStore();

const home = () => {
    router.visit("/");
};
</script>
