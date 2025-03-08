<script setup>
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { dialogBreakpoints } from "@/utils/helpers";
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";

const page = usePage();

const create = ref(false);
const form = useForm({
    title: null,
});

const storeCv = () => {
    form.post(route(page.props.routePrefix + "cv.store"), {
        preserveScroll: true,
        onSuccess: () => {
            create.value = false;
        },
    });
};
</script>

<template>
    <UiButton @click="create = true">
        <i class="ki-filled ki-plus-squared" @click="create = true"> </i>
        Nouveau CV
    </UiButton>

    <Dialog
        v-model:visible="create"
        modal
        :style="{ width: '20rem' }"
        :breakpoints="dialogBreakpoints"
        header=" Donne un nom à ton nouveau CV"
    >
        <form @submit.prevent="storeCv">
            <FloatLabel variant="in" class="mb-4">
                <InputText v-model="form.title" id="resume_title" fluid />
                <label for="resume_title">Nomme le cv</label>
            </FloatLabel>
            <InputError class="mb-1" :message="form.errors.title" />
            <FormButtonGroup :form="form" @canceled="create = false" />
        </form>
    </Dialog>
</template>
