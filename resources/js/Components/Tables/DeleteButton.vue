<template>
    <Button
        class="btn btn-sm btn-icon btn-clear btn-danger"
        icon="pi pi-trash"
        severity="danger"
        :loading="loading"
        @click="onClick"
    />
    <ConfirmDialog :group="group"></ConfirmDialog>
</template>

<script setup>
import { useCustomConfirm } from "@/composables/useCustomConfirm";
import { useConfirm, useToast } from "primevue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const emits = defineEmits(["clicked", "deleted"]);

const props = defineProps({
    deleteUrl: {
        type: String,
        default: null,
    },
    elementName: {
        type: String,
        default: "cet élément",
    },
});

const toast = useToast();
const confirm = useConfirm();
const { deleteConfirm } = useCustomConfirm(confirm);
const loading = ref(false);
const group = Math.random().toString();

const onClick = () => {
    if (props.deleteUrl) {
        deleteConfirm({
            group: group,
            message: `Voulez-vous vraiment supprimer ${props.elementName} ?`,
            accept: () => deleteItem(),
        });
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
            emits("deleted");
        },
        onFinish: () => {
            loading.value = false;
        },
    });
}
</script>
