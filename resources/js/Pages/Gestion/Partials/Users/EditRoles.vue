<template>
    <PickList
        v-model="list"
        dataKey="id"
        breakpoint="1400px"
        :show-source-controls="false"
        :show-target-controls="false"
    >
        <template #sourceheader>
            <div class="bg-gray-100 p-2 font-bold">Roles Non Attribués</div>
        </template>
        <template #targetheader>
            <div class="bg-gray-100 p-2 font-bold">Roles Attribués</div>
        </template>

        <template #option="{ option }">
            <Tag :value="option.name" severity="secondary" />
        </template>
    </PickList>
    <div class="flex justify-end mt-5">
        <Button
            type="button"
            label="Enregistrer"
            icon="pi pi-check"
            :loading="form.processing"
            @click="submit"
        />
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { useToast } from "primevue";
import { Role, User } from "@/types";

const props = defineProps({
    user: {
        type: Object as () => User,
        required: true,
    },
});

const page = usePage();
const toast = useToast();

const list = ref([[], []]);

const form = useForm({
    roles: null,
});

const submit = () => {
    form.transform((data) => ({
        roles: list.value[1].map((item: Role) => item.name),
    })).patch(route("user.roles.update", props.user.id), {
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
    const url = route(page.props.routePrefix + "role.index");
    await axios.get(url).then((response) => {
        const data = response.data;
        list.value[0] = data.filter(
            (item: Role) => !props.user.roles.find((r) => r.id === item.id),
        );
    });

    list.value[1] = props.user.roles || [];
});
</script>
