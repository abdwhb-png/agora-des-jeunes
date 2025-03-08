<template>
    <Button label="Commencer" raised class="mt-4" @click="start = true" />

    <Dialog
        v-model:visible="start"
        dismissable-mask
        modal
        :style="{ width: '25rem' }"
        :breakpoints="{ '575px': '98%' }"
        position="bottom"
        header="Pour commencer réponds à ces questions"
    >
        <form @submit.prevent="submit" class="mt-5 flex flex-col gap-7.5">
            <FloatLabel>
                <label for="profession">Profession actuelle</label>
                <Select
                    placeholder="Quelle est ta profession actuelle ?"
                    :options="['Elève', 'Etudiant', 'Travailleur', 'Autre']"
                    v-model="form.profession"
                    fluid
                    id="profession"
                />
            </FloatLabel>
            <FloatLabel>
                <label for="interests">Centre d'intérêts</label>
                <MultiSelect
                    v-model="form.interests"
                    :options="interests"
                    optionLabel="label"
                    optionValue="label"
                    placeholder="Qu'est ce qui t'intéresse le plus ?"
                    :maxSelectedLabels="2"
                    fluid
                />
            </FloatLabel>

            <FormButtonGroup
                :form="form"
                :show-cancel="false"
                submit-label="Continuer"
            />
        </form>
    </Dialog>
</template>

<script setup>
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";
import { dialogBreakpoints } from "@/utils/helpers";
import { useForm, usePage } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

const page = usePage();

const start = ref(false);
const interests = ref([
    {
        label: "Entreprendre",
        value: null,
    },
    {
        label: "Mettre en place un projet",
        value: null,
    },
    {
        label: "Trouver un emploi",
        value: null,
    },
    {
        label: "Etudier à l'étranger",
        value: null,
    },
    {
        label: "Trouver une bonne université",
        value: null,
    },
]);

const form = useForm({
    profession: null,
    interests: null,
});

onMounted(() => {
    if (page.props.flash.status == "just-registered") start.value = true;
});
</script>
