<template>
    <Loader v-if="loading" />
    <div v-else class="card">
        <div class="card-header justify-between">
            <Button
                @click="actionConfirm(() => updatePermissions(false))"
                :loading="form.processing"
                label="Tout retirer"
                class="btn btn-danger btn-sm btn-outline"
            />
            {{ rolePermsCount }} permissions attribuée(s)
            <Button
                @click="actionConfirm(() => updatePermissions(true))"
                :loading="form.processing"
                label="Tout attribuer"
                class="btn btn-primary btn-sm btn-outline"
            />
        </div>
        <div class="card-body">
            <Repeater
                :data="permissions"
                :roleId="role.id"
                :show-search="true"
            />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { Role } from "@/types";
import Repeater from "../Permissions/Repeater.vue";
import { useConfirm, useToast } from "primevue";
import { useCustomConfirm } from "@/composables/useCustomConfirm";

const props = defineProps({
    role: { type: Object as () => Role, required: true },
});

const page = usePage();
const toast = useToast();
const confirm = useConfirm();
const { actionConfirm } = useCustomConfirm(confirm);

const permissions = ref([]);
const rolePermsCount = ref(props.role.permissions.length || 0);
const loading = ref(false);

const form = useForm({
    permissions: {},
});

const updatePermissions = (status: Boolean) => {
    form.transform((data: any) => ({
        permissions: {
            value: permissions.value.map((item) => item.id),
            status: status,
        },
    })).put(route(page.props.routePrefix + "role.update", props.role.id), {
        only: ["flash", "roles"],
        onSuccess: (page) => {
            toast.add({
                severity: "success",
                summary: page.props.flash.success,
                life: 3000,
            });
            getPerms();
            if (!status) rolePermsCount.value = 0;
            else rolePermsCount.value = permissions.value.length;
        },
    });
};

onMounted(() => {
    getPerms();
});

async function getPerms() {
    loading.value = true;
    const url = route(page.props.routePrefix + "permission.index");
    await axios
        .get(url)
        .then((response: any) => {
            permissions.value = response.data;
        })
        .catch((error) => {
            console.log("Error while fetching permissions", error);
        })
        .finally(() => {
            loading.value = false;
        });
}
</script>
