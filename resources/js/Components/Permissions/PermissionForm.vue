<template>
    <form @submit.prevent="submit">
        <FloatLabel variant="on" class="mb-4">
            <InputText v-model="form.name" id="name" fluid />
            <label for="name">Nom de la permission</label>
            <InputError class="" :message="form.errors.name" />
        </FloatLabel>
        <FloatLabel variant="on" class="mb-4">
            <Textarea v-model="form.description" id="description" fluid />
            <label for="description"
                >Description de la permission (facultatif)</label
            >
            <InputError class="" :message="form.errors.description" />
        </FloatLabel>
        <FormButtonGroup :form="form" @canceled="$emit('canceled')" />
    </form>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";

const emits = defineEmits(["created", "updated", "canceled"]);

const props = defineProps({
    item: { type: Object, default: null },
});

const page = usePage();
const toast = useToast();

const form = useForm({
    _method: props.item ? "PUT" : "POST",
    name: props.item?.name || null,
    description: props.item?.description || null,
});

const submit = () => {
    const url = props.item
        ? route(page.props.routePrefix + "permission.update", props.item.id)
        : route(page.props.routePrefix + "permission.store");

    form.post(url, {
        only: ["flash", "permissions"],
        onSuccess: (page) => {
            toast.add({
                severity: "success",
                summary: page.props.flash.success,
                life: 5000,
            });

            emits(props.item ? "updated" : "created");
        },
    });
};
</script>
