<template>
    <form @submit.prevent="submit">
        <div class="flex flex-col space-y-1.5">
            <label class="form-label"> Nom </label>
            <div class="grow">
                <InputText
                    fluid
                    v-model="form.nom"
                    :placeholder="
                        'Ecris ' +
                        (isAuthUser ? 'ton' : 'le') +
                        ' nom de famille'
                    "
                />
                <InputError :message="form.errors.nom" class="mt-1" />
            </div>
        </div>
        <div class="flex flex-col space-y-1.5">
            <label class="form-label"> Prénom </label>
            <div class="grow">
                <InputText
                    fluid
                    v-model="form.prenom"
                    :placeholder="
                        'Ecris ' + (isAuthUser ? 'ton' : 'le') + ' prénom'
                    "
                />
                <InputError :message="form.errors.prenom" class="mt-1" />
            </div>
        </div>
        <div class="flex flex-col space-y-1.5">
            <label class="form-label"> Téléphone </label>
            <div class="grow">
                <InputText
                    fluid
                    v-model="form.phone"
                    :placeholder="
                        'Ecris ' +
                        (isAuthUser ? 'ton' : 'le') +
                        ' numéro de téléphone'
                    "
                />
                <InputError :message="form.errors.phone" class="mt-1" />
            </div>
        </div>
        <div class="flex flex-col space-y-1.5">
            <label class="form-label"> Sexe </label>
            <div class="grow">
                <Select
                    v-model="form.sexe"
                    :options="['Homme', 'Femme']"
                    fluid
                    :placeholder="
                        'Choisis ' + (isAuthUser ? 'ton' : 'le') + ' sexe'
                    "
                />
                <InputError :message="form.errors.sexe" class="mt-1" />
            </div>
        </div>
        <div class="flex flex-col space-y-1.5">
            <label class="form-label"> Date de naissance </label>
            <div class="grow">
                <DatePicker
                    v-model="form.date_naissance"
                    :placeholder="'jj/mm/aaaa'"
                    dateFormat="dd/mm/yy"
                    fluid
                />
                <InputError
                    :message="form.errors.date_naissance"
                    class="mt-1"
                />
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
import { ref, computed, watch } from "vue";
import dayjs from "dayjs";
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";

const props = defineProps({
    user: Object,
});

const page = usePage();
const isAuthUser = computed(() => props.user.id == page.props.auth.user.id);

const form = useForm({
    nom: null,
    prenom: null,
    phone: null,
    sexe: null,
    date_naissance: null,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        date_naissance: data.date_naissance
            ? dayjs(data.date_naissance).format("DD/MM/YYYY")
            : null,
    })).put(route("user.info.update", props.user.id), {
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
