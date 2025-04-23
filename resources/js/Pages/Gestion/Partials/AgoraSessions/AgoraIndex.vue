<script setup>
import { useMainStore } from "@/stores/main";
import { onMounted } from "vue";
import CreatePanel from "@/Components/Gestion/CreatePanel.vue";
import AgoraList from "./AgoraList.vue";
import AgoraForm from "./AgoraForm.vue";

const mainStore = useMainStore();

onMounted(async () => {
    await mainStore.fetchAgora();
});
</script>

<template>
    <div class="">
        <CreatePanel
            title="Session d'Agora"
            description="Créer et gérer les différentes sessions d'Agora."
            btn-text="Créer une Session"
            image="/gestion/images/presentation.png"
            :create-component="AgoraForm"
        />
        <Divider />
        <AgoraList
            :data="mainStore.agoraSessions.list"
            :filter-name="mainStore.agoraSessions.filter_name"
        />
    </div>
</template>
