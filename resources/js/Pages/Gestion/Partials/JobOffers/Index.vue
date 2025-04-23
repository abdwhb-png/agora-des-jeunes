<script setup>
import { useMainStore } from "@/stores/main";
import { onMounted } from "vue";
import CreatePanel from "@/Components/Gestion/CreatePanel.vue";
import JobForm from "./JobForm.vue";
import JobList from "./JobList.vue";

const mainStore = useMainStore();

onMounted(async () => {
    await mainStore.fetchJobOffers();
});
</script>

<template>
    <div class="">
        <CreatePanel
            title="Offres d'emplois"
            description="Créer et gérer les offres d'emploi à proposer."
            btn-text="Nouvelle offre"
            image="/gestion/images/emploi.png"
            :create-component="JobForm"
        />
        <Divider />
        <JobList
            :data="mainStore.jobOffers.list"
            :filter-name="mainStore.jobOffers.filter_name"
        />
    </div>
</template>
