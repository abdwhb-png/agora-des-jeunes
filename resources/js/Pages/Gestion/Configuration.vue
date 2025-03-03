<script setup>
import { useSidebarStore } from "@/stores/sidebar";
</script>

<template>
    <PageLayout
        title="Configuration du site"
        :component-props="{
            social_links: $page.props.social_links,
            site_settings: $page.props.site_settings,
            departements: $page.props.departements,
            jobs: $page.props.job_offers,
            trainings: $page.props.trainings,
        }"
    >
    </PageLayout>
</template>
