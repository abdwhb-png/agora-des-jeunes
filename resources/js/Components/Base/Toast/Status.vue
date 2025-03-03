<style scoped>
.container {
    width: auto !important;
}
</style>

<template>
    <Toast
        position="bottom-center"
        group="toastStatus"
        @close="onClose"
        class="container"
    >
        <template #message="{ message }">
            <div class="flex flex-col items-start flex-auto">
                <div class="flex items-center gap-2">
                    <i class="pi pi-exclamation-triangle" shape="circle" />
                    <span class="font-bold">{{ message.summary }}</span>
                </div>
                <div class="font-medium my-4">{{ message.detail }}</div>
            </div>
        </template>
    </Toast>
</template>

<script setup lang="ts">
import { useToast } from "primevue/usetoast";
import { ref, watch, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

interface Flash {
    fail?: string;
    success?: string;
    status?: string;
}

const props = defineProps({
    flash: Object as () => Flash,
    summary: {
        type: String,
        default: null,
    },
});

const toast = useToast();
const visible = ref(false);

const showToast = () => {
    if (!visible.value) {
        const { severity, summary, detail } = getToastData();
        toast.add({
            severity,
            summary,
            detail,
            group: "toastStatus",
            life: 30000, // 30 seconds
        });
        visible.value = true;
    }
};

const closeToast = () => {
    toast.removeGroup("toastStatus");
    visible.value = false;
};

const onClose = () => {
    visible.value = false;
};

onMounted(() => {
    router.on("start", (event) => {
        if (event.detail.visit.method.toLowerCase() !== "get") closeToast();
    });
});

watch(
    () => props.flash,
    (newFlash) => {
        if (newFlash.fail || newFlash.success || newFlash.status) showToast();
        else closeToast();
    },
    { immediate: true, deep: true },
);

function getToastData() {
    if (props.summary) {
        return { severity: "contrast", summary: props.summary, detail: "" };
    }
    if (props.flash?.fail) {
        return {
            severity: "error",
            summary: "Échec de l'opération",
            detail: props.flash.fail,
        };
    }
    if (props.flash?.success) {
        return {
            severity: "success",
            summary: "Succès de l'opération",
            detail: props.flash.success,
        };
    }
    if (props.flash?.status) {
        return {
            severity: "info",
            summary: "Statut de l'opération",
            detail: props.flash.status,
        };
    }
    return { severity: null, summary: "", detail: "" };
}
</script>
