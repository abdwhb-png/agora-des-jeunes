<template>
    <ToastError :errors="$page.props.errors" />
    <form @submit.prevent="submit">
        <div class="grid md:grid-cols-2 gap-4 pt-1.5">
            <div class="flex flex-col gap-4">
                <FloatLabel variant="on">
                    <InputText
                        v-model="form.title"
                        id="title"
                        required=""
                        fluid
                    />
                    <label class="required" for="title">Titre</label>
                </FloatLabel>
                <FloatLabel variant="on">
                    <InputText
                        v-model="form.location"
                        id="location"
                        required=""
                        fluid
                    />
                    <label class="required" for="location"
                        >Lieu de la formation</label
                    >
                </FloatLabel>
                <FloatLabel variant="on">
                    <DatePicker
                        id="start_date"
                        v-model="form.start_date"
                        dateOnly
                        showIcon
                        iconDisplay="input"
                        fluid
                    />
                    <label for="start_date">Date de début</label>
                </FloatLabel>

                <FloatLabel variant="on">
                    <DatePicker
                        id="end_date"
                        v-model="form.end_date"
                        dateOnly
                        showIcon
                        iconDisplay="input"
                        fluid
                    />
                    <label for="end_date">Date de fin</label>
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
            <div class="flex flex-col">
                <label for="description">Description</label>
                <Editor
                    v-model="form.description"
                    id="description"
                    editorStyle="height: 200px"
                />
            </div>
        </div>
        <FormButtonGroup :form="form" :show-cancel="false" />
    </form>
</template>

<script setup>
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "primevue";
import dayjs from "dayjs";
import ImageInput from "@/Components/ImageInput.vue";

const emits = defineEmits(["created", "updated", "canceled"]);

const props = defineProps({
    item: Object,
});

const toast = useToast();

const form = useForm({
    _method: props.item ? "PUT" : "POST",
    title: props.item?.title || null,
    location: props.item?.location || null,
    start_date: props.item?.start_date || null,
    end_date: props.item?.end_date || null,
    description: props.item?.description || null,
    image: props.item?.image || null,
});

const submit = () => {
    const url = props.item
        ? route("training.update", props.item.id)
        : route("training.store");

    form.transform((data) => ({
        ...data,
        start_date: data.start_date
            ? dayjs(data.start_date).format("YYYY-MM-DD HH:mm:ss")
            : null,
        end_date: data.end_date
            ? dayjs(data.end_date).format("YYYY-MM-DD HH:mm:ss")
            : null,
    })).post(url, {
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
