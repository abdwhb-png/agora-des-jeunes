<template>
    <form @submit.prevent="submit">
        <PickList
            v-model="list"
            dataKey="id"
            breakpoint="1400px"
            :show-source-controls="false"
            :show-target-controls="false"
        >
            <template #sourceheader>
                <div class="bg-gray-100 p-2 font-bold">
                    Permissions Non Attribués
                </div>
            </template>
            <template #targetheader>
                <div class="bg-gray-100 p-2 font-bold">
                    Permissions Attribués
                </div>
            </template>

            <template #option="{ option }">
                <Tag :value="option.name" severity="secondary" />
            </template>
        </PickList>
        <FormButtonGroup
            :form="form"
            :show-cancel="false"
            success-message="Permissions mises à jour."
        />
    </form>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { useToast } from "primevue";
import { Permission, User } from "@/types";
import { useAxios } from "@/composables/useAxios";

const props = defineProps({
    user: {
        type: Object as () => User,
        required: true,
    },
});

const page = usePage();
const toast = useToast();
const { fetchData } = useAxios();

const list = ref([[], []]);

const form = useForm({
    permissions: null,
});

const submit = () => {
    form.transform((data) => ({
        permissions: list.value[1].map((item: Permission) => item.name),
    })).patch(route("user.permissions.update", props.user.id), {
        preserveScroll: true,
        onSuccess: (page) => {
            toast.add({
                severity: "success",
                summary: page.props.flash.success,
                life: 5000,
            });
        },
    });
};

onMounted(async () => {
    const url = route(page.props.routePrefix + "permissions");
    const data = await fetchData(url, {
        errorMessage: "Erreur lors de la récupération de des rôles du site.",
    });
    list.value[0] = data?.filter(
        (item: Permission) =>
            !props.user.permissions?.find((p) => p.id === item.id),
    );

    list.value[1] = props.user.permissions || [];
});
</script>
