<script setup>
import { useSidebarStore } from "@/stores/sidebar";

defineProps({
    title: String,
    componentProps: Object,
});

const sidebarStore = useSidebarStore();
</script>

<template>
    <MainLayout :title>
        <div class="grid gap-5 lg:gap-7.5">
            <div class="grid lg:grid-cols-1 gap-5 lg:gap-7.5 items-stretch">
                <div class="">
                    <slot>
                        <component
                            :is="sidebarStore.currentComponent()"
                            v-bind="componentProps"
                        />
                    </slot>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
