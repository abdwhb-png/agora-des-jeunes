<template>
    <form @submit.prevent="submit">
        <div class="hidden">
            <div class="flex flex-col space-y-1.5">
                <label class="form-label"> Département de résidence </label>
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
        <div class="flex flex-col space-y-1.5">
            <label class="form-label"> Ville de résidence </label>
            <div class="grow">
                <Select
                    v-model="form.ville"
                    :options="communes"
                    editable
                    filter
                    optionLabel="name"
                    optionValue="name"
                    :placeholder="
                        'Ecris le nom de ' +
                        (isAuthUser ? 'ta' : 'la') +
                        ' ville'
                    "
                    fluid
                />
                <InputError :message="form.errors.ville" class="mt-1" />
            </div>
        </div>
        <div class="flex flex-col space-y-1.5">
            <label class="form-label"> Quartier </label>
            <div class="grow">
                <AutoComplete
                    v-model="form.quartier"
                    :placeholder="
                        'Ecris ' + (isAuthUser ? 'ton' : 'le') + ' quarier'
                    "
                    fluid
                    :suggestions="quartiers"
                    @complete="searchQuartier"
                />
                <InputError :message="form.errors.quartier" class="mt-1" />
            </div>
        </div>
        <div class="flex flex-col space-y-1.5">
            <label class="form-label"> Arrondissement (facultatif) </label>
            <div>
                <Select
                    v-model="form.arrondissement"
                    :options="selectedCommune?.arrondissements"
                    editable
                    optionLabel="name"
                    optionValue="name"
                    :placeholder="
                        'Ecris ' +
                        (isAuthUser ? 'ton' : 'l\'') +
                        ' arrondissement'
                    "
                    fluid
                />
                <InputError
                    :message="form.errors.arrondissement"
                    class="mt-1"
                />
            </div>
        </div>
        <div class="flex flex-col space-y-1.5">
            <label class="form-label"> Maison (facultatif) </label>
            <div class="">
                <InputText
                    v-model="form.maison"
                    :placeholder="
                        'Ecris le nom de ' +
                        (isAuthUser ? 'ta' : 'la') +
                        ' maison'
                    "
                    fluid
                />
                <InputError :message="form.errors.maison" class="mt-1" />
            </div>
        </div>
        <FormButtonGroup
            :form="form"
            :show-cancel="false"
            success-message="Adresse mise à jour."
        />
    </form>
</template>

<script setup lang="ts">
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, computed, onMounted, watch } from "vue";
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";
import { useViewport } from "@/composables/useViewport";
import { useMainStore } from "@/stores/main";
import { User } from "@/types";
import { FloatLabel } from "primevue";

const { width: viewportWidth, isMobile } = useViewport();

const props = defineProps({
    user: Object as () => User,
});

const page = usePage();

const mainStore = useMainStore();
const data = ref([]);

const isAuthUser = computed(() => props.user.id == page.props.auth.user.id);

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
    (newUser: User) => {
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
