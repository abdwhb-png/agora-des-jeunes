<script setup lang="ts">
import { ref } from "vue";
import FaqList from "./Faqs/FaqList.vue";
import CreatePanel from "@/Components/Gestion/CreatePanel.vue";
import { dialogBreakpoints } from "@/utils/helpers";
import FaqForm from "./Faqs/FaqForm.vue";
</script>

<template>
    <div class="">
        <CreatePanel
            title="Foire Aux Questions"
            description="Créer et gérer les questions réponses."
            btn-text="Ajouter une Q/R"
            image="/gestion/images/faq.png"
            :create-component="FaqForm"
        />
        <Divider />
        <FaqList
            :data="$page.props.faqs.list"
            :filter-name="$page.props.faqs.filter_name"
        />
    </div>
</template>
