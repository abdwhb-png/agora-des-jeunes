<script setup lang="ts">
import { useMainStore } from "@/stores/main";
import { ref, onMounted } from "vue";
import { FilterMatchMode } from "@primevue/core/api";

const props = defineProps({
    departements: { type: Object, default: null },
});

const mainStore = useMainStore();

const expandedRows = ref({});

const filtersOne = ref({
    name: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const filtersTwo = ref({
    ...filtersOne.value,
    arrondissements_names: { value: null, matchMode: FilterMatchMode.CONTAINS },
    quartiers: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const expandAll = () => {
    expandedRows.value = props.departements.reduce(
        (acc, p) => (acc[p.id] = true) && acc,
        {},
    );
};
const collapseAll = () => {
    expandedRows.value = null;
};

onMounted(() => {
    mainStore.fetchDepartements();
});
</script>

<template>
    <NotPermitted v-if="!$page.props.can.manageDepartements" />
    <Card v-else>
        <template #title>Départements, Communes & Arrondissements</template>
        <template #content>
            <DataTable
                :value="departements"
                v-model:expandedRows="expandedRows"
                v-model:filters="filtersOne"
                filterDisplay="row"
                dataKey="id"
                paginator
                :rows="20"
                :rowsPerPageOptions="[5, 10, 20, 50]"
            >
                <template #header>
                    <div class="flex flex-wrap justify-end gap-2">
                        <Button
                            text
                            icon="pi pi-plus"
                            label="Tout déplier"
                            @click="expandAll"
                        />
                        <Button
                            text
                            icon="pi pi-minus"
                            label="Tout replier"
                            @click="collapseAll"
                        />
                    </div>
                </template>
                <Column expander style="width: 5rem" />
                <Column field="name" header="Département">
                    <template #filter="{ filterModel, filterCallback }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            @input="filterCallback()"
                            placeholder="Chercher un département"
                        />
                    </template>
                </Column>
                <Column field="counts" header="Totaux">
                    <template #body="{ data, field }">
                        <p v-for="(item, index) in data[field]" :key="index">
                            {{ item }} {{ index }}
                        </p>
                    </template>
                </Column>
                <template #expansion="slotProps">
                    <div class="p-4">
                        <h5 class="font-semibold">
                            Communes de: {{ slotProps.data.name }}
                        </h5>
                        <DataTable
                            :value="slotProps.data.communes"
                            v-model:filters="filtersTwo"
                            filterDisplay="row"
                            paginator
                            :rows="5"
                            :rowsPerPageOptions="[5, 10, 20, 50]"
                        >
                            <Column
                                field="name"
                                header="Nom de commune"
                                sortable
                                style="width: 20%"
                            ></Column>
                            <Column
                                field="arrondissements_names"
                                header="Arrondissements"
                                :show-filter-menu="false"
                                style="width: 40%"
                            >
                                <template
                                    #filter="{ filterModel, filterCallback }"
                                >
                                    <InputText
                                        v-model="filterModel.value"
                                        type="text"
                                        @input="filterCallback()"
                                        placeholder="Chercher un arrondissement"
                                    />
                                </template>
                            </Column>
                            <Column
                                field="quartiers"
                                header="Tous les quartiers"
                                :show-filter-menu="false"
                                style="width: 40%"
                            >
                                <template
                                    #filter="{ filterModel, filterCallback }"
                                >
                                    <InputText
                                        v-model="filterModel.value"
                                        type="text"
                                        @input="filterCallback()"
                                        placeholder="Chercher un quartier"
                                    />
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </template>
            </DataTable>
        </template>
    </Card>
</template>
