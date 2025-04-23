<script setup>
import { useMainStore } from "@/stores/main";
import { onMounted } from "vue";
import CreatePanel from "@/Components/Gestion/CreatePanel.vue";
import TrainingForm from "./TrainingForm.vue";
import TrainingList from "./TrainingList.vue";

const mainStore = useMainStore();

onMounted(async () => {
    await mainStore.fetchTrainings();
});
</script>

<template>
    <div class="">
        <CreatePanel
            title="Formations"
            description="Créer et gérer les formations à proposer."
            btn-text="Nouvelle formation"
            image="/gestion/images/formation.png"
            :create-component="TrainingForm"
        />
        <Divider />
        <TrainingList
            :data="mainStore.trainings.list"
            :filter-name="mainStore.trainings.filter_name"
        />
    </div>
</template>
