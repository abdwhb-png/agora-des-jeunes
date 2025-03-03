<script setup>
import { ref } from "vue";
import CreatePanel from "@/Components/Gestion/CreatePanel.vue";
import AgoraList from "./AgoraSessions/AgoraList.vue";
import AgoraForm from "./AgoraSessions/AgoraForm.vue";
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
            :data="$page.props.agora_sessions.list"
            :filter-name="$page.props.agora_sessions.filter_name"
        />
    </div>
</template>
