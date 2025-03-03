<template>
    <div class="flex flex-wrap pt-2.5 gap-2" :class="className">
        <Message
            v-if="form.recentlySuccessful"
            severity="success"
            closable
            class="w-full lg:w-auto"
        >
            {{ successMessage }}
        </Message>
        <div class="flex justify-between gap-2 lg:order-2">
            <Button
                v-if="showCancel"
                type="button"
                :label="cancelLabel"
                @click="emits('canceled')"
                severity="secondary"
            />
            <Button
                type="submit"
                :label="submitLabel"
                icon="pi pi-check"
                :loading="form.processing"
            />
        </div>
    </div>
</template>

<script setup>
const emits = defineEmits(["canceled", "submitted"]);

defineProps({
    form: Object,
    className: {
        type: String,
        default: "justify-end",
    },
    submitLabel: {
        type: String,
        default: "Enregistrer",
    },
    cancelLabel: {
        type: String,
        default: "Annuler",
    },
    showCancel: {
        type: Boolean,
        default: true,
    },
    successMessage: {
        type: String,
        default: "Données mises à jour.",
    },
});
</script>
