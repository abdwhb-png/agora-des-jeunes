<script setup lang="ts">
import { computed, markRaw } from "vue";
import { router } from "@inertiajs/vue3";
import { useStorage } from "@vueuse/core";
import Overview from "./Partials/Overview.vue";
import ProfileTabs from "./Partials/ProfileTabs.vue";
import Projects from "./Partials/Projects.vue";
import Cvs from "./Partials/Cvs.vue";

interface Tab {
    title: string;
    url?: string;
    component?: any;
}

defineProps({
    cvs: Object,
    projects: Object,
});

const tabs: Tab[] = [
    {
        title: "Mes Projets",
        component: markRaw(Projects),
    },
    {
        title: "Mes CVs",
        component: markRaw(Cvs),
    },
    {
        title: "Mes Formations",
        url: "",
    },
];

const activeTab = useStorage("activeTab", tabs[0].title);

const currentComponent = computed(
    () => tabs.find((tab) => tab.title === activeTab.value)?.component,
);

const handleTabClick = (tab) => {
    activeTab.value = tab.title;

    if (tab.url) {
        router.visit(tab.url);
    }
};
</script>

<template>
    <MainLayout title="Mon Profil Membre">
        <Overview :user="$page.props.auth.user" />
        <ProfileTabs
            :user="$page.props.auth.user"
            :tabs="tabs"
            :active-tab="activeTab"
            @tabClick="handleTabClick"
        />
        <component
            :is="currentComponent"
            :user="$page.props.auth.user"
            :cvs="cvs"
            :projects="projects"
        />
    </MainLayout>
</template>
