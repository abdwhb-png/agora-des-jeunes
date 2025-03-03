<script setup>
import { useSidebarStore } from "@/stores/sidebar";
</script>

<template>
    <PageLayout
        title="Utilisateurs"
        :component-props="{
            data: $page.props.users,
            canShow: $page.props.can.viewUsers,
        }"
    >
    </PageLayout>
</template>
