<script setup lang="ts">
import { ref } from "vue";
import { LaravelPagination } from "@/types";
import { FilterMatchMode } from "@primevue/core/api";

import EditUser from "./EditUser.vue";
import EditButton from "@/Components/Tables/EditButton.vue";

const props = defineProps({
    data: { type: Object as () => LaravelPagination<any>, default: null },
    canShow: Boolean,
});

const statuses = ref([
    { label: "Actif", value: true },
    { label: "Desactivé", value: false },
]);

const filters = ref({
    "base.tel": { value: null, matchMode: FilterMatchMode.CONTAINS },
    status: { value: null, matchMode: FilterMatchMode.EQUALS },
});
</script>

<template>
    <NotPermitted v-if="!canShow" />
    <div v-else>
        <CustomDataTable
            title="Liste des utilisateurs"
            :paginated="data"
            showGridlines
            :filters="filters"
            filterName="users"
            :show-creation-date="true"
        >
            <template>
                <Column style="width: 1%">
                    <template #body="{ data }">
                        <EditButton
                            dialog-header="Modifier un utilisateur"
                            dialog-width="70rem"
                            :edit-component="EditUser"
                            :component-props="{ id: data.id }"
                        />
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
                                <a
                                    class="leading-none font-medium text-sm text-gray-900 hover:text-primary"
                                    href="#"
                                >
                                    <CopyBtn :text="data.full_name" />
                                    {{ data.full_name }}
                                </a>
                                <span
                                    class="text-xs text-gray-700 font-normal truncate"
                                    v-tooltip.bottom="data.email"
                                >
                                    <CopyBtn :text="data.email" />
                                    {{ data.email }}
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <span
                                v-if="data.status"
                                class="badge badge-primary badge-outline rounded-[30px]"
                            >
                                <span
                                    class="size-1.5 rounded-full bg-primary me-1.5"
                                >
                                </span>
                                Actif
                            </span>
                            <span
                                v-else
                                class="badge badge-danger badge-outline rounded-[30px]"
                            >
                                <span
                                    class="size-1.5 rounded-full bg-danger me-1.5"
                                >
                                </span>
                                Compte Desactivé
                            </span>
                        </div>
                    </template>

                    <template #filter="{ filterModel, filterCallback }">
                        <Select
                            v-model="filterModel.value"
                            @change="filterCallback()"
                            :options="statuses"
                            option-label="label"
                            option-value="value"
                            placeholder="Statut du compte"
                            style="min-width: 12rem"
                            :showClear="true"
                        >
                            <template #option="slotProps">
                                <Tag
                                    :value="slotProps.option.label"
                                    :severity="
                                        slotProps.option.value
                                            ? 'info'
                                            : 'danger'
                                    "
                                />
                            </template>
                        </Select>
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
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            size="small"
                            @input="filterCallback()"
                            placeholder="Numéro de téléphone"
                        />
                    </template>
                </Column>
                <Column field="roles" header="Roles" style="width: 15%">
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
