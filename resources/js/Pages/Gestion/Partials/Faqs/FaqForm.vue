<template>
    <form @submit.prevent="submit" class="flex flex-col gap-5 my-2">
        <div>
            <FloatLabel variant="on">
                <AutoComplete
                    v-model="form.category"
                    fluid
                    id="category"
                    option-label="name"
                    option-value="name"
                    :suggestions="features"
                    @complete="search"
                />
                <label for="category">Catégorie</label>
            </FloatLabel>
            <InputError class="mt-1" :message="form.errors.category" />
        </div>
        <div>
            <FloatLabel variant="on">
                <InputText v-model="form.question" id="question" fluid />
                <label for="question">Question</label>
            </FloatLabel>
            <InputError class="mt-1" :message="form.errors.question" />
        </div>
        <div>
            <label for="answer">Réponse</label>
            <CustomEditor v-model="form.answer" editorStyle="height: 200px" />
            <InputError class="mt-1" :message="form.errors.answer" />
        </div>
        <FormButtonGroup :form="form" @canceled="$emit('canceled')" />
    </form>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useMainStore } from "@/stores/main";
import { useToast } from "primevue/usetoast";
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";
import CustomEditor from "@/Components/Base/CustomEditor.vue";

interface Feature {
    id: number;
    name: string;
}
const emits = defineEmits(["canceled", "created", "updated"]);

const props = defineProps({
    item: Object,
});

const page = usePage();
const mainStore = useMainStore();
const toast = useToast();

const features = ref<Feature[]>([]);

const form = useForm({
    _method: props.item ? "PUT" : "POST",
    category: props.item?.category || null,
    question: props.item?.question || null,
    answer: props.item?.answer || null,
    is_active: props.item?.is_active,
});

const search = (event: any) => {
    features.value = mainStore.appFeatures.filter((feature) => {
        return feature.name.toLowerCase().includes(event.query.toLowerCase());
    });
};

const submit = () => {
    const url = props.item
        ? route(page.props.routePrefix + "faq.update", props.item.id)
        : route(page.props.routePrefix + "faq.store");

    form.post(url, {
        onSuccess: (page) => {
            toast.add({
                severity: "success",
                summary: page.props.flash.success,
                life: 3000,
            });
            emits(props.item ? "updated" : "created");
        },
    });
};

onMounted(async () => {
    await mainStore.fetchFeatures();
});
</script>
