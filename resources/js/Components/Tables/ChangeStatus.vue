<template>
    <label class="switch switch-sm" v-if="Object.keys(item).includes(field)">
        <input
            :checked="item[field]"
            :disabled="item.loading"
            class="status"
            name="check"
            type="checkbox"
            @change="updateStatus(item)"
        />
        <span class="switch-label order-1"> </span>
    </label>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";

const emits = defineEmits(["statusChanged"]);

const props = defineProps({
    field: {
        type: String,
        default: "published",
    },
    item: {
        type: Object,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
});

const toast = useToast();
const form = useForm({
    [props.field]: props.item[props.field],
});

const updateStatus = (item) => {
    if (!item.id) return;

    form.transform((data) => ({
        [props.field]: !item[props.field],
    })).patch(route(props.routeName, item.id), {
        onStart: () => {
            item.loading = true;
        },
        onSuccess: (page) => {
            toast.add({
                severity: "success",
                summary: "Statut de publication mis à jour",
                detail: !item[props.field] ? "PUBLIE" : "NON PUBLIE",
                life: 5000,
            });

            emits("statusChanged");
        },
        onFinish: () => {
            item.loading = false;
        },
    });
};
</script>
