<script setup lang="ts">
import { ref } from "vue";
import { LaravelPagination } from "@/types";
import { FILTER_NAMES } from "@/constants";
import { FilterMatchMode } from "@primevue/core/api";

import EditUser from "./EditUser.vue";
import EditButton from "@/Components/Tables/EditButton.vue";
import { DropdownMenuRadioItem } from "@/Components/ui/dropdown-menu";
import StatusTag from "@/Components/Shared/StatusTag.vue";

const props = defineProps({
    data: { type: Object as () => LaravelPagination<any>, default: null },
    can: Object,
    statuses: Array | Object,
});

const filters = ref({
    status: { value: null, matchMode: FilterMatchMode.EQUALS },
});

const filtersKeys = [
    {
        key: "status",
        label: "Statut du compte",
    },
];
</script>

<template>
    <NotPermitted v-if="!can.viewUsers" />
    <div v-else>
        <CustomDataTable
            title="Liste des utilisateurs"
            :paginated="data"
            showGridlines
            :filters="filters"
            :filterName="FILTER_NAMES.users"
            :data-filters="$page.props.filters"
            :show-creation-date="true"
        >
            <template>
                <Column
                    style="width: 1%"
                    field="status"
                    :show-filter-menu="false"
                >
                    <template #filter="{ filterModel, filterCallback }">
                        <Select
                            v-model="filterModel.value"
                            @change="filterCallback()"
                            :options="statuses"
                            option-label="label"
                            option-value="value"
                            placeholder="Statut du compte"
                            :showClear="true"
                        >
                            <template #option="slotProps">
                                <StatusTag :status="slotProps.option" />
                            </template>
                        </Select>
                    </template>
                    <template #body="{ data }">
                        <div
                            class="flex flex-col gap-2 justify-center items-center"
                        >
                            <EditButton
                                dialog-header="Modifier un utilisateur"
                                dialog-width="70rem"
                                :edit-component="EditUser"
                                :component-props="{
                                    id: data.id,
                                    viewRoles: can.viewRoles,
                                    viewPerms: can.viewPerms,
                                }"
                            />
                            <template
                                v-for="status in statuses"
                                :key="status.label"
                            >
                                <StatusTag
                                    v-if="data.status == status.value"
                                    :status="status"
                                    :is-bagde="true"
                                />
                            </template>
                        </div>
                    </template>
                </Column>
                <Column
                    header="Utilisateur"
                    sortable
                    sortField="email"
                    filterField="status"
                    :show-filter-menu="false"
                    style="width: 34%"
                >
                    <template #body="{ data }">
                        <div class="flex items-center gap-2.5 mb-1">
                            <div class="">
                                <img
                                    class="h-9 rounded-full"
                                    :src="data.profile_photo_url"
                                />
                            </div>
                            <div class="flex flex-col gap-0.5 max-w-[80%]">
                                <CopyBtn
                                    :text="data.full_name || '--'"
                                    class="leading-none font-medium text-sm text-gray-900"
                                />
                                <CopyBtn
                                    :text="data.email"
                                    class="text-xs text-gray-700 hover:text-blue-600 font-normal truncate dsy-tooltip"
                                    :data-tip="data.email"
                                />
                            </div>
                        </div>
                    </template>
                </Column>
                <Column
                    field="base"
                    header="Informations"
                    filter-field="base.tel"
                    :show-filter-menu="true"
                    style="width: 30%"
                >
                    <template #body="{ data, field }">
                        <div class="flex flex-col gap-0.5">
                            <span
                                v-for="(info, index) in data[field]"
                                :key="index"
                                class="text-xs text-gray-700 font-normal"
                            >
                                <span class="underline">{{ index }}</span
                                >&nbsp;:&nbsp;{{ info }}
                            </span>
                        </div>
                    </template>
                </Column>
                <Column
                    v-if="can.viewRoles"
                    field="roles"
                    header="Roles"
                    style="width: 15%"
                >
                    <template #body="{ data, field }">
                        <div
                            class="flex flex-wrap items-center align-middle gap-2.5"
                        >
                            <span
                                v-for="(role, index) in data[field]"
                                :key="index"
                                class="badge badge-sm badge-light badge-outline"
                            >
                                {{ role }}
                            </span>
                        </div>
                    </template>
                </Column>
                <Column
                    field="last_login_at"
                    header="Dernière connexion"
                    style="width: 10%"
                >
                    <template #body="{ data, field }">
                        <span class="text-gray-500 text-sm font-normal">{{
                            data[field]
                        }}</span>
                    </template>
                </Column>
            </template>
        </CustomDataTable>
    </div>
</template>
