<template>
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
            <div class="bg-gray-100 p-2 font-bold">Permissions Attribués</div>
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
import { Permission, User } from "@/types";

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
    const url = route(page.props.routePrefix + "permission.index");
    await axios.get(url).then((response) => {
        const data = response.data;
        list.value[0] = data.filter(
            (item: Permission) =>
                !props.user.permissions?.find((p) => p.id === item.id),
        );
    });

    list.value[1] = props.user.permissions || [];
});
</script>
