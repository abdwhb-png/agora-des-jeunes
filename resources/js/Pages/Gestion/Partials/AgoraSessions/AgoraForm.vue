<script>
export default {
    name: "AgoraSessionForm",
};
</script>

<script setup>
import { ref, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useUsersStore } from "@/stores/users";
import { useToast } from "primevue/usetoast";
import dayjs from "dayjs";
import ImageInput from "@/Components/ImageInput.vue";

const emits = defineEmits(["created", "updated", "canceled"]);

const props = defineProps({
    item: Object,
});

const page = usePage();
const toast = useToast();

const usersStore = useUsersStore();
const managers = ref([]);

const form = useForm({
    theme: props.item?.theme || "",
    lieu: props.item?.lieu || "",
    date: props.item?.date || "",
    heure_debut: props.item?.heure_debut || "",
    heure_fin: props.item?.heure_fin || "",
    places: props.item?.places || 150,
    presentateur: props.item?.presentateur || null,
    description: props.item?.description || "",
    image: props.item?.image || null,
});

const search = (event) => {
    managers.value = usersStore.managers.filter((user) => {
        return (
            user.fullname.toLowerCase().includes(event.query.toLowerCase()) ||
            user.email.toLowerCase().includes(event.query.toLowerCase())
        );
    });
};

const submit = () => {
    form.clearErrors();

    const url = props.item
        ? route(page.props.routePrefix + "agora-session.update", props.item.id)
        : route(page.props.routePrefix + "agora-session.store");

    form.transform((data) => ({
        ...data,
        _method: props.item ? "PUT" : "POST",
        // date: dayjs(data.date).format("YYYY-MM-DD HH:mm:ss"),
        heure_debut: dayjs(data.heure_debut).format("HH:mm"),
        heure_fin: dayjs(data.heure_fin).format("HH:mm"),
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
                        <IconField>
                            <InputText v-model="form.theme" id="theme" fluid />
                            <InputIcon class="pi pi-bullseye" />
                        </IconField>
                        <label for="theme">Thème de la session </label>
                    </FloatLabel>
                    <InputError class="mt-1" :message="form.errors.theme" />
                </div>
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <IconField>
                            <InputText v-model="form.lieu" id="lieu" fluid />
                            <InputIcon class="pi pi-map-marker" />
                        </IconField>
                        <label for="lieu">Lieu </label>
                    </FloatLabel>
                    <InputError class="mt-1" :message="form.errors.lieu" />
                </div>
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <DatePicker
                            id="date"
                            v-model="form.date"
                            dateOnly
                            showIcon
                            iconDisplay="input"
                            fluid
                        />
                        <label for="date">Date </label>
                    </FloatLabel>
                    <InputError class="mt-1" :message="form.errors.date" />
                </div>
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <DatePicker
                            id="debut"
                            v-model="form.heure_debut"
                            timeOnly
                            showIcon
                            iconDisplay="input"
                            fluid
                        >
                            <template #inputicon="slotProps">
                                <i
                                    class="pi pi-clock"
                                    @click="slotProps.clickCallback"
                                />
                            </template>
                        </DatePicker>
                        <label for="debut">Heure de début </label>
                    </FloatLabel>
                    <InputError
                        class="mt-1"
                        :message="form.errors.heure_debut"
                    />
                </div>
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <DatePicker
                            id="fin"
                            v-model="form.heure_fin"
                            format="H:i:s"
                            timeOnly
                            showIcon
                            iconDisplay="input"
                            fluid
                        >
                            <template #inputicon="slotProps">
                                <i
                                    class="pi pi-clock"
                                    @click="slotProps.clickCallback"
                                />
                            </template>
                        </DatePicker>
                        <label for="fin">Heure de fin (facultatif) </label>
                    </FloatLabel>
                    <InputError class="mt-1" :message="form.errors.heure_fin" />
                </div>
            </div>
            <div class="md:col-span-1">
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <InputNumber
                            v-model="form.places"
                            id="places"
                            :min="1"
                            :step="10"
                            :show-buttons="true"
                            fluid
                        />
                        <label for="places" class="capitalize"
                            >Nombre de places</label
                        >
                    </FloatLabel>
                    <InputError class="mt-1" :message="form.errors.places" />
                </div>
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <IconField>
                            <AutoComplete
                                v-model="form.presentateur"
                                fluid
                                id="presentateur"
                                :suggestions="managers"
                                @complete="search"
                            />
                            <InputIcon class="pi pi-user" />
                        </IconField>
                        <label for="presentateur">Présentateur</label>
                    </FloatLabel>
                    <InputError
                        class="mt-1"
                        :message="form.errors.presentateur"
                    />
                </div>
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <IconField>
                            <ImageInput
                                id="image"
                                :image-name="form.image?.name || form.image"
                                @selected="form.image = $event"
                            />
                            <InputIcon class="pi pi-image" />
                        </IconField>
                        <label for="image">Image d'affiche (facultatif)</label>
                    </FloatLabel>
                    <InputError class="mt-1" :message="form.errors.image" />
                </div>
                <div class="mb-4">
                    <FloatLabel variant="on">
                        <Textarea
                            v-model="form.description"
                            id="description"
                            rows="3"
                            fluid
                        />
                        <label for="description"
                            >Description de la session (facultatif)</label
                        >
                    </FloatLabel>
                    <InputError
                        class="mt-1"
                        :message="form.errors.description"
                    />
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
