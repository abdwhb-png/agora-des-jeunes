<template>
    <MainLayout title="A propos de moi">
        <div class="w-full md:w-[80%] lg:w-[60%] mx-auto">
            <Message v-if="$page.props.flash.status" severity="info">
                {{ $page.props.flash.status }}
            </Message>
            <div class="card">
                <div class="card-body px-0 pr-5">
                    <ProfileStepper :user="$page.props.auth.user" />
                </div>
            </div>
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
