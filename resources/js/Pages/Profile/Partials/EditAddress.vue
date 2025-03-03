<template>
    <form @submit.prevent="submit">
        <div class="w-full">
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                <label class="max-w-56 min-w-2/5"> Département </label>
                <div class="grow">
                    <Select
                        v-model="form.departement"
                        :options="data.departements"
                        filter
                        optionLabel="name"
                        optionValue="name"
                        placeholder="Choisis le departement"
                        fluid
                        :style="{
                            maxWidth: viewportWidth <= 300 ? '205px' : 'auto',
                        }"
                    />
                    <InputError
                        :message="form.errors.departement"
                        class="mt-1"
                    />
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                <label class="max-w-56 min-w-2/5"> Ville </label>
                <div class="grow">
                    <Select
                        v-model="form.ville"
                        :options="communes"
                        editable
                        optionLabel="name"
                        optionValue="name"
                        placeholder="Ecris la ville"
                        fluid
                    />
                    <InputError :message="form.errors.ville" class="mt-1" />
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                <label class="max-w-56 min-w-2/5"> Quartier </label>
                <div class="grow">
                    <AutoComplete
                        v-model="form.quartier"
                        placeholder="Ecris le quartier"
                        fluid
                        :suggestions="quartiers"
                        @complete="searchQuartier"
                    />
                    <InputError :message="form.errors.quartier" class="mt-1" />
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                <label class="flex items-center gap-1 max-w-56 min-w-2/5">
                    Arrondissement (facultatif)
                </label>
                <div class="grow">
                    <Select
                        v-model="form.arrondissement"
                        :options="selectedCommune?.arrondissements"
                        editable
                        optionLabel="name"
                        optionValue="name"
                        placeholder="Ecris l'arrondissement"
                        fluid
                    />
                    <InputError
                        :message="form.errors.arrondissement"
                        class="mt-1"
                    />
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                <label class="flex items-center gap-1 max-w-56 min-w-2/5">
                    Maison (facultatif)
                </label>
                <div class="grow">
                    <InputText
                        v-model="form.maison"
                        placeholder="Ecris le nom de la maison"
                        fluid
                    />
                    <InputError :message="form.errors.maison" class="mt-1" />
                </div>
            </div>
        </div>
        <FormButtonGroup
            :form="form"
            :show-cancel="false"
            success-message="Adresse mise à jour."
        />
    </form>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, computed, onMounted, watch } from "vue";
import { useApi } from "@/composables/useApi";
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";
import { useViewport } from "@/composables/useViewport";
import { useMainStore } from "@/stores/main";

const { width: viewportWidth, isMobile } = useViewport();

const props = defineProps({
    user: Object,
});

const mainStore = useMainStore();
const data = ref([]);

const selectedDepartement = computed(() =>
    mainStore.departements.find(
        (departement) => departement.name === form.departement,
    ),
);
const communes = computed(() => {
    if (selectedDepartement.value) {
        return selectedDepartement.value.communes;
    }
    return mainStore.communes || [];
});

const selectedCommune = computed(() =>
    communes.value.find((commune) => commune.name === form.ville),
);

const quartiers = ref([]);

const searchQuartier = (event) => {
    quartiers.value = selectedCommune.value.quartiers.filter((quartier) => {
        return quartier.toLowerCase().includes(event.query.toLowerCase());
    });
};

const form = useForm({
    departement: null,
    ville: null,
    quartier: null,
    arrondissement: null,
    maison: null,
});

const submit = () => {
    form.put(route("user.info.update", props.user.id), {
        preserveScroll: true,
        onStart: () => {
            form.clearErrors();
        },
        onSuccess: (page) => {
            // user.value = page.props.auth.user;
        },
    });
};

watch(
    () => props.user,
    (newUser) => {
        form.departement = newUser.info.departement || null;
        form.ville = newUser.info.ville || null;
        form.quartier = newUser.info.quartier || null;
        form.arrondissement = newUser.info.arrondissement || null;
        form.maison = newUser.info.maison || null;
    },
    { immediate: true, deep: true },
);

onMounted(() => {
    mainStore.fetchDepartements();
});
</script>
