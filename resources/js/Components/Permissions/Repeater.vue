<template>
    <ToastError :errors="$page.props.errors" />
    <div
        class="flex justify-between items-center"
        v-if="showSearch && data.length"
    >
        <div class="input input-sm max-w-56">
            <i class="ki-filled ki-magnifier"> </i>
            <input
                placeholder="Rechercher une permission"
                type="text"
                v-model="searchInput"
                @input="search"
            />
        </div>
        <span class="font-bold"> {{ items.length }} résultats </span>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 py-2">
        <div
            v-for="(item, index) in items"
            :key="item.id + 'perms' + index"
            class="rounded-xl border p-4 flex items-center justify-between gap-2.5"
        >
            <div class="flex items-center gap-3.5">
                <div class="relative size-[45px] shrink-0">
                    <svg
                        class="w-full h-full stroke-gray-300 fill-gray-100"
                        fill="none"
                        height="48"
                        viewBox="0 0 44 48"
                        width="44"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506
			18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937
			39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z"
                            fill=""
                        ></path>
                        <path
                            d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506
			18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937
			39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z"
                            stroke=""
                        ></path>
                    </svg>
                    <div
                        class="absolute inset-0 flex items-center justify-center"
                    >
                        <i
                            class="text-1.5xl text-gray-500"
                            :class="getIcon('permission')"
                        >
                        </i>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <span
                        class="flex items-center gap-1.5 leading-none font-medium text-sm text-gray-900 uppercase"
                    >
                        {{ item.name }}
                    </span>
                    <p v-if="item.description" class="text-2sm text-gray-700">
                        {{ item.description }}
                    </p>
                    <div
                        class="text-2sm text-gray-700 flex flex-col gap-1 w-full"
                    >
                        <span v-if="item.created">
                            Crée le {{ item.created }}</span
                        >
                        <div
                            v-if="userStore.hasPermission('view_roles')"
                            class="dropdown"
                            data-dropdown="true"
                            data-dropdown-trigger="click"
                        >
                            <button class="dropdown-toggle text-primary">
                                Attribué à {{ item.roles?.length || 0 }} roles
                                <i
                                    class="ki-outline ki-down !text-sm dropdown-open:hidden"
                                >
                                </i>
                                <i
                                    class="ki-outline ki-up !text-sm hidden dropdown-open:block"
                                >
                                </i>
                            </button>
                            <div class="dropdown-content w-full max-w-56">
                                <div
                                    class="p-4 text-sm text-gray-900 font-medium"
                                >
                                    Liste des roles
                                </div>
                                <div class="border-b border-b-gray-200"></div>
                                <div class="scrollable-y m-2 p-2 h-[150px]">
                                    <div class="flex flex-col gap-3">
                                        <Tag
                                            v-for="role in item.roles"
                                            :key="role.id"
                                            severity="secondary"
                                            :value="role.name"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ConfirmsPassword
                @confirmed="deleteConfirm(() => deleteItem(item))"
            >
                <Button
                    v-if="showDelete && userStore.hasPermission('delete_role')"
                    type="button"
                    icon="ki-filled ki-trash"
                    :loading="item.loading"
                    class="btn btn-sm btn-danger btn-icon btn-outline"
                />
            </ConfirmsPassword>
            <div
                v-if="roleId && userStore.hasPermission('edit_permission')"
                class="switch switch-sm"
            >
                <input
                    :checked="hasRole(item)"
                    :disabled="item.loading"
                    name="param"
                    type="checkbox"
                    :value="hasRole(item) ? 1 : 0"
                    @change="onStatusChange(item)"
                />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    name: "PermissionsRepeater",
};
</script>

<script setup lang="ts">
import { router, usePage, useForm } from "@inertiajs/vue3";
import { watch, ref } from "vue";
import { useToast } from "primevue/usetoast";
import { useCustomConfirm } from "@/composables/useCustomConfirm";
import { useConfirm } from "primevue/useconfirm";
import { Role, Permission } from "@/types";

import ConfirmsPassword from "@/Components/ConfirmsPassword.vue";
import ToastError from "@/Components/Base/Toast/ValidationError.vue";
import { getIcon } from "@/utils/helpers";
import { useUserStore } from "@/stores/user";

const emits = defineEmits(["statusChanged"]);

const props = defineProps({
    data: { type: Object as () => Permission[], default: null },
    roleId: { type: Number, default: null },
    showDelete: { type: Boolean, default: false },
    showSearch: { type: Boolean, default: true },
});

const page = usePage();
const toast = useToast();
const userStore = useUserStore();

const confirm = useConfirm();
const { deleteConfirm } = useCustomConfirm(confirm);

const items = ref([]);
const searchInput = ref(null);

const form = useForm({
    permission: null,
});

const hasRole = (item: Permission) => {
    return item.roles?.find((role: Role) => role.id === props.roleId);
};

const search = () => {
    items.value = props.data?.filter((item: Permission) =>
        item.name.toLowerCase().includes(searchInput.value.toLowerCase()),
    );
};

const onStatusChange = (item: Permission) => {
    form.transform((data) => ({
        permission: {
            id: item.id,
            status: !hasRole(item),
        },
    })).put(route(page.props.routePrefix + "role.update", props.roleId), {
        only: ["flash", "roles"],
        onStart: () => {
            item.loading = true;
        },
        onSuccess: (page) => {
            toast.add({
                severity: "success",
                summary: page.props.flash.success,
                life: 5000,
            });
            emits("statusChanged");
        },
        onFinish: () => {
            item.loading = false;
        },
    });
};

const deleteItem = (item: Permission) => {
    router.delete(
        route(page.props.routePrefix + "permission.destroy", item.id),
        {
            only: ["flash", "permissions"],
            onStart: () => {
                item.loading = true;
            },
            onSuccess: () => {
                toast.add({
                    severity: "success",
                    summary: page.props.flash.success,
                    life: 5000,
                });
            },
            onFinish: () => {
                item.loading = false;
            },
        },
    );
};

watch(
    () => props.data,
    (newData) => {
        items.value = newData.map((item) => ({
            ...item,
            loading: false, // Assure la réactivité
        }));

        if (searchInput.value) {
            search();
        }
    },
    { immediate: true, deep: true },
);
</script>
