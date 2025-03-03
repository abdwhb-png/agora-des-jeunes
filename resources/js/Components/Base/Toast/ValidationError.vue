<style scoped>
.container {
    width: auto !important;
}
</style>

<template>
    <Toast
        position="bottom-center"
        group="toastError"
        @close="onClose"
        class="container"
    >
        <template #message="slotProps">
            <div class="flex flex-col items-start flex-auto">
                <div class="flex items-center gap-2">
                    <i class="pi pi-exclamation-triangle" shape="circle" />
                    <span class="font-bold">{{
                        slotProps.message.summary
                    }}</span>
                </div>
                <div class="font-medium my-4" v-html="formattedJson"></div>
                <Button
                    v-if="false"
                    size="small"
                    label="Fermer"
                    class="align-self-end"
                    severity="contrast"
                    @click="closeToast()"
                ></Button>
            </div>
        </template>
    </Toast>
</template>

<script setup>
import { formatJsonToPrint } from "@/utils/helpers";
import { useToast } from "primevue/usetoast";
import { ref, watch, computed, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    errors: Object,
    summary: {
        type: String,
        default: "Erreur de validation",
    },
});

const toast = useToast();
const visible = ref(false);

const showToast = () => {
    if (!visible.value) {
        toast.add({
            severity: "error",
            summary: props.summary,
            group: "toastError",
            duration: 1000 * 60, // 1 minute
        });
        visible.value = true;
    }
};

const closeToast = () => {
    toast.removeGroup("toastError");
    visible.value = false;
};

const onClose = () => {
    visible.value = false;
};

const formattedJson = computed(() => {
    return formatJsonToPrint(props.errors);
});

onMounted(() => {
    router.on("start", (event) => {
        if (event.detail.visit.method.toLowerCase() !== "get") closeToast();
    });
});

watch(
    () => props.errors,
    (newErrors) => {
        if (newErrors && Object.keys(newErrors).length > 0) showToast();
        else closeToast();
    },
    { immediate: true },
);
</script>
