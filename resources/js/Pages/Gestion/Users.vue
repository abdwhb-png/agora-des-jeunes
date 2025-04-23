<script setup>
import { useSidebarStore } from "@/stores/sidebar";
</script>

<template>
    <PageLayout
        title="Utilisateurs"
        :component-props="{
            data: $page.props.users,
            can: $page.props.can,
            statuses: $page.props.user_statuses,
        }"
    >
    </PageLayout>
</template>
