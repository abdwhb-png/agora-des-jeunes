<template>
    <ToastError :errors="$page.props.errors" />
    <form @submit.prevent="submit">
        <div class="flex flex-col gap-4 pt-1.5 mb-3">
            <FloatLabel variant="on">
                <InputText v-model="form.title" id="title" required="" fluid />
                <label class="required" for="title">Titre</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <InputText
                    v-model="form.company"
                    id="company"
                    required=""
                    fluid
                />
                <label class="required" for="company">Entreprise</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <InputText
                    v-model="form.location"
                    id="location"
                    required=""
                    fluid
                />
                <label class="required" for="location"
                    >Lieu ou Adresse de l'entreprise</label
                >
            </FloatLabel>
            <FloatLabel variant="on">
                <InputText
                    v-model="form.salary_range"
                    id="salary_range"
                    fluid
                />
                <label for="salary_range">Salaire</label>
            </FloatLabel>

            <FloatLabel variant="on">
                <InputText
                    v-model="form.application_link"
                    id="application_link"
                    fluid
                />
                <label for="application_link">Lien de candidature</label>
            </FloatLabel>

            <FloatLabel variant="on">
                <IconField>
                    <ImageInput
                        id="image"
                        :image-name="form.image?.name || form.image"
                        @selected="form.image = $event"
                    />
                    <InputIcon class="pi pi-image" />
                </IconField>
                <label for="image">Image (facultatif)</label>
            </FloatLabel>
        </div>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="flex flex-col">
                <label for="description">Description</label>
                <Editor
                    v-model="form.description"
                    id="description"
                    editorStyle="height: 200px"
                />
            </div>
            <div class="flex flex-col">
                <label for="requirements">Exigences</label>
                <Editor
                    v-model="form.requirements"
                    id="requirements"
                    editorStyle="height: 200px"
                />
            </div>
        </div>
        <FormButtonGroup :form="form" :show-cancel="false" />
    </form>
</template>

<script setup>
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";
import ImageInput from "@/Components/ImageInput.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "primevue";

const emits = defineEmits(["created", "updated", "canceled"]);

const props = defineProps({
    item: Object,
});

const toast = useToast();

const form = useForm({
    _method: props.item ? "PUT" : "POST",
    title: props.item?.title || null,
    company: props.item?.company || null,
    location: props.item?.location || null,
    salary_range: props.item?.salary_range || null,
    description: props.item?.description || null,
    requirements: props.item?.requirements || null,
    application_link: props.item?.application_link || null,
    image: props.item?.image || null,
});

const submit = () => {
    const url = props.item
        ? route("job.update", props.item.id)
        : route("job.store");

    form.post(url, {
        preserveScroll: true,
        onSuccess: (page) => {
            form.reset();
            toast.add({
                severity: "success",
                summary: page.props.flash.success,
                life: 5000,
            });
            emits(props.item ? "updated" : "created");
        },
    });
};
</script>
