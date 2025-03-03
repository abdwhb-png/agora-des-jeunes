<template>
    <Button
        class="btn btn-sm btn-icon btn-clear btn-danger"
        icon="pi pi-trash"
        severity="danger"
        :loading="loading"
        @click="onClick"
    />
    <ConfirmDialog></ConfirmDialog>
</template>

<script setup>
import { useCustomConfirm } from "@/composables/useCustomConfirm";
import { useConfirm, useToast } from "primevue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const emits = defineEmits(["clicked"]);

const props = defineProps({
    deleteUrl: {
        type: String,
        default: null,
    },
});

const loading = ref(false);

const toast = useToast();
const confirm = useConfirm();
const { deleteConfirm } = useCustomConfirm(confirm);

const onClick = () => {
    if (props.deleteUrl) {
        deleteConfirm(() => deleteItem());
    }

    emits("clicked");
};

function deleteItem() {
    router.delete(props.deleteUrl, {
        onStart: () => {
            loading.value = true;
        },
        onSuccess: (page) => {
            toast.add({
                severity: "success",
                summary: page.props.flash.success || "Element supprimé",
                life: 5000,
            });
        },
        onFinish: () => {
            loading.value = false;
        },
    });
}
</script>
