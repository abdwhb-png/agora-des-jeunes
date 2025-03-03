<template>
    <ToastError :errors="$page.props.errors" />

    <div
        class="flex justify-between items-center"
        v-if="showSearch && data.length"
    >
        <div class="input input-sm max-w-56">
            <i class="ki-filled ki-magnifier"> </i>
            <input
                placeholder="Rechercher un role"
                type="text"
                @input="search"
            />
        </div>
        <span class="font-bold"> {{ items.length }} résultats </span>
    </div>
    <div
        class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5 lg:gap-7.5 py-2"
    >
        <Dialog
            v-model:visible="showPermissions"
            @hide="role = null"
            modal
            maximizable
            :dismissable-mask="true"
            :header="'Permissions du role : ' + role?.name"
            :style="{ width: '50rem' }"
            :breakpoints="dialogBreakpoints"
        >
            <RolePerms :role="role" />
        </Dialog>

        <Dialog
            v-model:visible="edit"
            modal
            :dismissable-mask="true"
            header="Modifier un role"
            :style="{ width: '25rem' }"
        >
            <div class="pt-2">
                <UpdateForm
                    :item="role"
                    @updated="formCancel"
                    @canceled="formCancel"
                />
            </div>
        </Dialog>
        <div
            v-for="(item, index) in items"
            :key="item.id"
            class="card flex flex-col gap-5 p-5 lg:p-7.5"
        >
            <div class="flex items-center flex-wrap justify-between gap-1">
                <div class="flex items-center gap-2.5">
                    <div class="relative size-[44px] shrink-0">
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
                                :class="getIcon('role')"
                            >
                            </i>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-md font-medium text-gray-900 hover:text-primary-active mb-px capitalize"
                        >
                            {{ item.name }}
                        </span>
                        <span
                            v-if="userStore.hasPermission('view_permissions')"
                            class="text-2sm hover:text-gray-700 text-primary"
                        >
                            {{ item.permissions.length }}
                            Permissions
                        </span>
                    </div>
                </div>
                <div class="menu inline-flex" data-menu="true">
                    <div
                        class="menu-item menu-item-dropdown"
                        data-menu-item-offset="0, 10px"
                        data-menu-item-placement="bottom-end"
                        data-menu-item-placement-rtl="bottom-start"
                        data-menu-item-toggle="dropdown"
                        data-menu-item-trigger="click|lg:click"
                    >
                        <button
                            class="menu-toggle btn btn-sm btn-icon btn-light btn-clear"
                        >
                            <i class="ki-filled ki-dots-vertical"> </i>
                        </button>
                        <div
                            class="menu-dropdown menu-default w-full max-w-[175px]"
                            data-menu-dismiss="true"
                        >
                            <div
                                class="menu-item"
                                v-if="
                                    showEdit &&
                                    userStore.hasPermission('edit_role')
                                "
                            >
                                <button
                                    class="menu-link"
                                    type="button"
                                    @click="
                                        edit = true;
                                        role = item;
                                    "
                                >
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-notepad-edit">
                                        </i>
                                    </span>
                                    <span class="menu-title"> Modifier </span>
                                </button>
                            </div>
                            <div
                                class="menu-item"
                                v-if="
                                    userStore.hasPermission('view_permissions')
                                "
                            >
                                <button
                                    class="menu-link"
                                    type="button"
                                    @click="
                                        role = item;
                                        showPermissions = true;
                                    "
                                >
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-key-square"> </i>
                                    </span>
                                    <span class="menu-title">
                                        Permissions
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p v-if="item.description" class="text-2sm text-gray-700">
                {{ item.description }}
            </p>
            <p class="text-2sm text-gray-800 flex flex-col gap-1">
                <span> Crée le {{ item.created }}</span>
                <span>Modifié {{ item.updated }}</span>
            </p>
        </div>
    </div>
</template>

<script lang="ts">
export default {
    name: "RolesRepeater",
};
</script>

<script setup lang="ts">
import { ref, watch } from "vue";
import { dialogBreakpoints, getIcon } from "@/utils/helpers";
import UpdateForm from "./RoleForm.vue";
import RolePerms from "./RolePerms.vue";
import { Role } from "@/types";
import { useUserStore } from "@/stores/user";

const props = defineProps({
    data: { type: Object as () => Role[], default: null },
    showEdit: { type: Boolean, default: false },
    showSearch: { type: Boolean, default: true },
});

const userStore = useUserStore();

const items = ref([]);

const edit = ref(false);
const showPermissions = ref(false);

const role = ref(null);

const formCancel = () => {
    role.value = null;
    edit.value = false;
};

const search = (event: Event) => {
    items.value = props.data?.filter((item: Role) =>
        item.name.toLowerCase().includes(event.target.value.toLowerCase()),
    );
};

watch(
    () => props.data,
    (newData) => {
        items.value = newData;
    },
    { immediate: true, deep: true },
);
</script>
