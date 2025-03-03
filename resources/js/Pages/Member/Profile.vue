<script setup>
import Overview from "./Partials/Overview.vue";
import ProfileTabs from "./Partials/ProfileTabs.vue";
</script>

<template>
    <MainLayout title="Mon Profil Membre">
        <Overview :user="$page.props.auth.user" />
        <ProfileTabs :user="$page.props.auth.user" />
    </MainLayout>
</template>
