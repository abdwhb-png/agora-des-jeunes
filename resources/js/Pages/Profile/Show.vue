<template>
    <MainLayout title="Profil">
        <div class="flex w-full justify-center p-x-auto items-center">
            <Message
                v-if="$page.props.flash.status"
                severity="info"
                class="mb-3"
            >
                {{ $page.props.flash.status }}
            </Message>
            <ProfileStepper
                :user="$page.props.auth.user"
                :step-value="$page.props.stepValue"
            />
        </div>
    </MainLayout>
</template>

<script setup>
import ProfileStepper from "./Partials/ProfileStepper.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>
