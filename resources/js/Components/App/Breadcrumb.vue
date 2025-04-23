<template>
    <div class="container-fixed">
        <div
            class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5"
        >
            <div class="flex flex-col justify-center gap-2">
                <div class="flex items-center gap-2">
                    <Link href="/" class="btn btn-icon btn-sm">
                        <i class="ki-filled ki-home"></i>
                        <span class="ml-2">/</span>
                    </Link>
                    <h1 class="text-xl font-medium leading-none text-gray-900">
                        {{ title }}
                    </h1>
                </div>
                <div
                    class="flex items-center gap-2 text-sm font-normal text-gray-700"
                >
                    {{ description }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <UiButton @click="onReload" variant="outline">
                    <RefreshCw />
                    Actualiser
                </UiButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import { RefreshCw } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import { toast } from "vue-sonner";

defineProps({
    title: String,
    description: String,
});

const onReload = () => {
    const content = document.getElementById("content");
    router.reload({
        onStart: () => {
            content.classList.add("animate-pulse");
        },
        onFinish: () => {
            content.classList.remove("animate-pulse");
            toast("Actualisation", {
                description: "La page a été actualisée avec succès.",
                action: {
                    label: "Fermer",
                    onClick: () => console.log("Fermer  "),
                },
            });
        },
    });
};
</script>
