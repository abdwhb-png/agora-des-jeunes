<script setup>
import EmailForm from "./EmailForm.vue";
import PasswordForm from "./PasswordForm.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <EmailForm :user="user" />
    <br />
    <PasswordForm />
</template>
