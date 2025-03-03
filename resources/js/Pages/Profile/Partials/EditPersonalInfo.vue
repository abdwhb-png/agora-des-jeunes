<template>
    <form @submit.prevent="submit">
        <div class="w-full">
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                <label class="flex items-center gap-1 max-w-56 min-w-2/5">
                    Nom
                </label>
                <div class="grow">
                    <InputText
                        fluid
                        v-model="form.nom"
                        placeholder="Ecris le nom de famille"
                    />
                    <InputError :message="form.errors.nom" class="mt-1" />
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                <label class="flex items-center gap-1 max-w-56 min-w-2/5">
                    Prénom
                </label>
                <div class="grow">
                    <InputText
                        fluid
                        v-model="form.prenom"
                        placeholder="Ecris le prénom"
                    />
                    <InputError :message="form.errors.prenom" class="mt-1" />
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                <label class="flex items-center gap-1 max-w-56 min-w-2/5">
                    Téléphone
                </label>
                <div class="grow">
                    <InputText
                        fluid
                        v-model="form.phone"
                        placeholder="Ecris le numero de telephone"
                    />
                    <InputError :message="form.errors.phone" class="mt-1" />
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="flex items-center flex-wrap gap-2.5">
                <label class="max-w-56 min-w-2/5"> Sexe </label>
                <div class="grow">
                    <Select
                        v-model="form.sexe"
                        :options="['Homme', 'Femme']"
                        fluid
                        placeholder="Choisis le sexe"
                    />
                    <InputError :message="form.errors.sexe" class="mt-1" />
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="flex items-baseline flex-wrap lg:flex-nowrap gap-2.5">
                <label class="flex items-center gap-1 max-w-56 min-w-2/5">
                    Date de naissance
                </label>
                <div class="grow">
                    <DatePicker
                        v-model="form.date_naissance"
                        placeholder="Ecris la date de naissance"
                        dateFormat="dd/mm/yy"
                        fluid
                    />
                    <InputError
                        :message="form.errors.date_naissance"
                        class="mt-1"
                    />
                </div>
            </div>
        </div>
        <FormButtonGroup
            :form="form"
            :show-cancel="false"
            success-message="Informations mises à jour."
        />
    </form>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    nom: null,
    prenom: null,
    phone: null,
    sexe: null,
    date_naissance: null,
});

const submit = () => {
    form.put(route("user.info.update", props.user.id), {
        preserveScroll: true,
        onStart: () => {
            form.clearErrors();
        },
        onSuccess: (page) => {},
    });
};

watch(
    () => props.user,
    (newUser) => {
        form.nom = newUser.info.nom || null;
        form.prenom = newUser.info.prenom || null;
        form.phone = newUser.phone || null;
        form.sexe = newUser.info.sexe || null;
        form.date_naissance = newUser.info.date_naissance || null;
    },
    { immediate: true, deep: true },
);
</script>
