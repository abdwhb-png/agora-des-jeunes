<script setup>
import { reactive, markRaw } from "vue";
import { Deferred, usePage } from "@inertiajs/vue3";
import Settings from "./Partials/Configuration/SiteSettings/Settings.vue";
import SocialLinks from "./Partials/Configuration/SiteSettings/SocialLinks.vue";
import Departements from "./Partials/Configuration/Departements.vue";

const props = defineProps({
    social_links: Object,
    site_settings: Object,
    departements: Object,
    can: Object,
});

const tabs = reactive([
    {
        name: "Réglages du site",
        description: "Configurer les paramètres généraux du site.",
        component: markRaw(Settings),
        props: {
            site_settings: props.site_settings,
        },
        can: props.can.manageConfig,
    },
    {
        name: "Réseaux Sociaux",
        description: "Configurer les liens vers les réseaux sociaux.",
        component: markRaw(SocialLinks),
        props: {
            social_links: props.social_links,
        },
        can: props.can.manageConfig,
    },
    {
        name: "Départements du Bénin",
        description: "Gérer les départements et leurs informations.",
        component: markRaw(Departements),
        props: {
            departements: props.departements,
        },
        can: props.can.manageDepartements,
    },
]);
</script>

<template>
    <MainLayout title="Configuration du site">
        <Tabs :value="tabs[0].name">
            <TabList>
                <Tab
                    v-for="(tab, index) in tabs"
                    :key="tab.name"
                    :value="tab.name"
                    >{{ tab.name }}</Tab
                >
            </TabList>
            <TabPanels>
                <TabPanel
                    v-for="(tab, index) in tabs"
                    :key="tab.name"
                    :value="tab.name"
                >
                    <template v-if="tab.can">
                        <component
                            v-if="tab.name != 'Départements du Bénin'"
                            :is="tab.component"
                            v-bind="tab.props"
                        ></component>
                        <Deferred v-else data="departements">
                            <template #fallback>
                                <div>Chargement...</div>
                            </template>
                            <component
                                :is="tab.component"
                                :departements="$page.props.departements"
                            ></component>
                        </Deferred>
                    </template>
                    <NotPermitted v-else />
                </TabPanel>
            </TabPanels>
        </Tabs>
    </MainLayout>
</template>
