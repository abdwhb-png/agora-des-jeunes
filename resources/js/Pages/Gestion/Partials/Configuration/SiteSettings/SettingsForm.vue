<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Réglages de base</h3>
            <div>
                <span class="text-sm"
                    >Dernière modification :
                    {{ dayjs(updated_at).format("DD/MM/YYYY HH:mm:ss") }}</span
                >
            </div>
        </div>
        <div class="card-body">
            <form @submit.prevent="submit" class="flex flex-col gap-5">
                <template v-for="(item, index) in form.data()" :key="index">
                    <div>
                        <FloatLabel variant="on">
                            <Textarea
                                v-if="
                                    [
                                        'site_description',
                                        'site_keywords',
                                    ].includes(index)
                                "
                                v-model="form[index]"
                                :id="index"
                                fluid
                            />
                            <InputText
                                v-else
                                v-model="form[index]"
                                :id="index"
                                fluid
                            />
                            <label :for="index" class="capitalize">
                                {{ index }}
                            </label>
                        </FloatLabel>
                        <InputError
                            class="mt-1"
                            :message="form.errors[index]"
                        />
                    </div>
                </template>

                <FormButtonGroup :form="form" :show-cancel="false" />
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import dayjs from "dayjs";
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";

const props = defineProps({
    setting: Object,
});

const page = usePage();

const { id, updated_at, ...formData } = props.setting;

const form = useForm({
    ...formData,
});

const submit = () => {
    form.put(route(page.props.routePrefix + "site-settings.update", id));
};
</script>
