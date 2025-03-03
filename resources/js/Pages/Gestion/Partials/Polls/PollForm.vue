<script>
export default {
    name: "PollForm",
};
</script>

<script setup>
import { ref, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useUsersStore } from "@/stores/users";
import { useToast } from "primevue/usetoast";
import dayjs from "dayjs";

const emits = defineEmits(["created", "updated", "canceled"]);

const props = defineProps({
    item: Object,
});

const page = usePage();
const toast = useToast();

const usersStore = useUsersStore();

const form = useForm({
    title: props.item?.title || null,
    description: props.item?.description || null,
    start_at: props.item?.start_at || null,
    end_at: props.item?.end_at || null,
    is_public: Boolean(props.item?.is_public) || true,
    show_options: Boolean(props.item?.show_options),
    options: props.item?.options || null,
});

const addOption = () => {
    const newOption = {
        option_text: null,
    };

    if (Array.isArray(form.options)) {
        // Si options est un tableau, on ajoute une nouvelle option
        form.options.push(newOption);
    } else if (form.options && typeof form.options === "object") {
        // Si options est un objet, on ajoute une nouvelle clé avec une valeur unique
        const uniqueKey = `option_${Object.keys(form.options).length + 1}`;
        form.options = { ...form.options, [uniqueKey]: newOption };
    } else {
        // Si options est null ou autre chose, on l'initialise avec une première option
        form.options = [newOption]; // ou `{ option_1: newOption }` si tu préfères un objet
    }
};

const submit = () => {
    form.clearErrors();

    const url = props.item
        ? route(page.props.routePrefix + "poll.update", props.item.id)
        : route(page.props.routePrefix + "poll.store");

    form.transform((data) => ({
        ...data,
        _method: props.item ? "PUT" : "POST",
        options: form.options
            ? Object.values(form.options).filter((option) =>
                  option.option_text?.trim(),
              )
            : [],
        // date: dayjs(data.date).format("YYYY-MM-DD HH:mm:ss"),
    })).post(url, {
        preserveScroll: true,
        onSuccess: (page) => {
            toast.add({
                severity: "success",
                summary: page.props.flash.success,
                life: 5000,
            });
            form.reset();

            emits(props.item ? "updated" : "created", form);
        },
    });
};

onMounted(() => {
    usersStore.fetchManagers();
});
</script>

<template>
    <div class="flex flex-col gap-6 my-2">
        <div class="grid md:grid-cols-2 gap-5 lg:gap-7.5 items-stretch">
            <div class="md:col-span-1">
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <InputText v-model="form.title" id="title" fluid />
                        <label for="title">Titre du sondage</label>
                    </FloatLabel>
                    <InputError class="mt-1" :message="form.errors.title" />
                </div>
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <Select
                            v-model="form.is_public"
                            id="is_public"
                            :options="[
                                { label: 'Ouvert à tous', value: true },
                                {
                                    label: 'Uniquement aux membres',
                                    value: false,
                                },
                            ]"
                            option-label="label"
                            option-value="value"
                            fluid
                        />
                        <label for="is_public">Public </label>
                    </FloatLabel>
                    <InputError class="mt-1" :message="form.errors.is_public" />
                </div>
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <DatePicker
                            id="debut"
                            v-model="form.start_at"
                            date-format="dd/mm/yy"
                            dateOnly
                            showIcon
                            iconDisplay="input"
                            fluid
                        />
                        <label for="debut">Date de début </label>
                    </FloatLabel>
                    <InputError class="mt-1" :message="form.errors.start_at" />
                </div>
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <DatePicker
                            id="fin"
                            v-model="form.end_at"
                            date-format="dd/mm/yy"
                            dateOnly
                            showIcon
                            iconDisplay="input"
                            fluid
                        />
                        <label for="fin">Date de fin (facultatif) </label>
                    </FloatLabel>
                    <InputError class="mt-1" :message="form.errors.end_at" />
                </div>

                <div class="mb-4">
                    <FloatLabel variant="on">
                        <Textarea
                            v-model="form.description"
                            id="description"
                            rows="3"
                            fluid
                        />
                        <label for="description">Description du sondage </label>
                    </FloatLabel>
                    <InputError
                        class="mt-1"
                        :message="form.errors.description"
                    />
                </div>
            </div>
            <div class="md:col-span-1">
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <Select
                            v-model="form.show_options"
                            id="show_options"
                            :options="[
                                { label: 'Prédéfini', value: true },
                                { label: 'Réponse Libre', value: false },
                            ]"
                            option-label="label"
                            option-value="value"
                            fluid
                        />
                        <label for="show_options">Option de réponse </label>
                    </FloatLabel>
                    <InputError
                        class="mt-1"
                        :message="form.errors.show_options"
                    />
                    <InputError class="mt-1" :message="form.errors.options" />
                </div>
                <Message severity="secondary" v-if="form.show_options === false"
                    >Les gens pourront répondre ce qu'ils souhaitent</Message
                >
                <div v-if="form.show_options === true">
                    <div class="mb-2 flex justify-end">
                        <Button
                            label="Ajouter une option"
                            icon="pi pi-plus"
                            class="btn btn-primary btn-outline btn-sm"
                            unstyled
                            @click="addOption"
                        />
                    </div>
                    <div v-if="form.options" class="card">
                        <div class="card-header">
                            Inscrivez au moins 2 options de réponse
                        </div>
                        <div class="card-body">
                            <div
                                v-for="(option, index) in form.options"
                                :key="index"
                                class="mb-4"
                            >
                                <div class="flex gap-1">
                                    <FloatLabel variant="on">
                                        <IconField>
                                            <InputText
                                                :id="'option_' + index"
                                                fluid
                                                v-model="option.option_text"
                                            />
                                            <InputIcon class="pi pi-bullseye" />
                                        </IconField>
                                        <label :for="'option_' + index"
                                            >Réponse {{ index + 1 }}</label
                                        >
                                    </FloatLabel>
                                    <Button
                                        @click="form.options.splice(index, 1)"
                                        icon="pi pi-times"
                                        outlined
                                        severity="danger"
                                        size="small"
                                    />
                                </div>
                                <InputError
                                    class="mt-1"
                                    :message="
                                        form.errors[
                                            `options.${index}.option_text`
                                        ]
                                    "
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-between gap-2 mt-4">
        <Button
            type="button"
            label="Annuler"
            severity="secondary"
            @click="emits('canceled')"
        ></Button>
        <Button
            type="button"
            :label="item ? 'Mettre à jour' : 'Enregistrer'"
            @click="submit"
            :loading="form.processing"
        ></Button>
    </div>
</template>
