<template>
    <div
        class="card card-grid h-full"
        :style="{ maxWidth: false ? viewportWidth + 'px' : 'auto' }"
    >
        <div class="card-header">
            <slot name="filter">
                <SearchFilter
                    v-if="showSearch"
                    :filter-name="filterName"
                    :show-filters="false"
                    :data-filters="dataFilters || $page.props.filters"
                    @searched="emits('filtered')"
                    @reseted="emits('filtered')"
                />
            </slot>
            <div class="card-title">
                {{ title }}
                <span v-if="paginated?.total">
                    {{ `(total ${paginated?.total || ""})` }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <div
                class="datatable-initialized"
                data-datatable="true"
                data-datatable-page-size="5"
            >
                <div class="scrollable-x-auto">
                    <DataTable
                        class="table table-auto"
                        data-datatable-table="true"
                        v-bind="$attrs"
                        ref="dt"
                        :value="tableData"
                        v-model:filters="filters"
                        filterDisplay="row"
                        :loading="loading"
                        scrollable
                        :scrollHeight="dtScrollHeight"
                        @sort="onSort"
                        @update:filters="onFilterUpdate"
                        aria-label="Data Table"
                    >
                        <template #empty>
                            <slot name="empty">
                                <div
                                    class="flex gap-4 p-4 items-center grow rounded-xl border border-dashed border-secondary bg-secondary-light"
                                >
                                    <i
                                        class="ki-outline ki-cross-square text-3xl text-secondary"
                                    >
                                    </i>
                                    <div class="flex flex-col gap-0.5">
                                        <p class="text text-lg font-normal">
                                            Aucun résultat trouvé
                                        </p>
                                    </div>
                                </div>
                            </slot>
                        </template>

                        <template #loading>
                            <slot name="loading">
                                <Message
                                    severity="contrast"
                                    icon="pi pi-hourglass"
                                >
                                    Chargement...</Message
                                >
                            </slot>
                        </template>

                        <!-- Content -->
                        <slot></slot>
                        <!-- End Content -->

                        <!-- Creation Date -->
                        <Column
                            v-if="showCreationDate"
                            field="created_at"
                            header="Date de création"
                            sortable
                            style="max-width: 11rem"
                        >
                            <template #body="{ data, field }">
                                {{ data[field] || "--" }}
                            </template>
                            <template #filter="{ filterModel, filterCallback }">
                                <InputText
                                    style="min-width: 5rem; max-width: 7rem"
                                    size="small"
                                    v-model="filterModel.value"
                                    @input="filterCallback()"
                                    placeholder="jj/mm/aaaa"
                                />
                            </template>
                        </Column>
                        <!-- End Creation Date -->

                        <!-- Update Date -->
                        <Column
                            v-if="showUpdateDate"
                            field="updated_at"
                            header="Dernière modification"
                            style="max-width: 11rem"
                            sortable
                        >
                            <template #body="{ data, field }">
                                {{ data[field] || "--" }}
                            </template>
                            <template #filter="{ filterModel, filterCallback }">
                                <InputText
                                    style="min-width: 5rem; max-width: 7rem"
                                    size="small"
                                    v-model="filterModel.value"
                                    @input="filterCallback()"
                                    placeholder="jj/mm/aaaa"
                                />
                            </template>
                        </Column>
                        <!-- End Update Date -->

                        <template #footer>
                            <slot name="footer"> </slot>
                        </template>
                    </DataTable>
                </div>
            </div>
        </div>

        <div
            v-if="showPagination"
            class="card-footer justify-center md:justify-end"
        >
            <Pagination
                :paginated="paginated"
                :filterName="filterName"
                :data-filters="$page.props.filters"
            />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from "vue";
import { useFilter } from "@/composables/useFilter";
import { dtScrollHeight } from "@/utils";
import { parseDate } from "@/utils/helpers";
import { LaravelPagination } from "@/types";
import { useViewport } from "@/composables/useViewport";
import { FilterMatchMode } from "@primevue/core/api";

import SearchFilter from "@/Components/Shared/Search/SearchFilter.vue";

// Define emitted events with proper types
const emits = defineEmits<{
    (e: "searched"): void;
    (e: "filtered"): void;
}>();

defineOptions({
    inheritAttrs: false,
});

interface TableFilters {
    [key: string]: { value: any; matchMode: string };
}

const props = defineProps({
    title: {
        type: String,
        default: "Liste",
    },
    paginated: {
        type: Object as () => LaravelPagination<any>,
        default: () => ({}),
    },
    filters: {
        type: Object as () => TableFilters,
        default: () => ({}),
    },
    filterName: {
        type: String,
        default: "",
    },
    dataFilters: {
        type: Object,
        default: () => ({}),
    },
    showSearch: {
        type: Boolean,
        default: true,
    },
    showPagination: {
        type: Boolean,
        default: true,
    },
    showCreationDate: {
        type: Boolean,
        default: false,
    },
    showUpdateDate: {
        type: Boolean,
        default: false,
    },
});

const { width: viewportWidth } = useViewport();

// Initialize datatable filters with proper typing
const filters = ref<TableFilters>({
    ...props.filters,
    created_at: { value: null, matchMode: FilterMatchMode.CONTAINS },
    updated_at: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const tableData = computed(() => {
    const sourceData = props.paginated?.data;
    const tab = Array.isArray(sourceData) ? sourceData : [];

    return tab.map((item: any) => ({
        ...item,
        created_at: parseDate(item.created_at),
        updated_at: parseDate(item.updated_at, "frReadable"),
    }));
});

const { loading, sortState, updateSort, updateFilters } = useFilter({
    filterName: props.filterName,
    sortOptions: {
        defaultSortField: "created_at",
        defaultSortDirection: "desc",
    },
    onSearched: (page) => emits("filtered"),
});

// Implement proper sort handler with typing
const onSort = (event: { sortField: string; sortOrder: number }): void => {
    updateSort(event.sortField, event.sortOrder, (page) => {
        // Optional callback when sort is complete
        console.log("Sorting completed!");
    });
};

const onFilterUpdate = (filters: Record<string, any>): void => {
    // Transform the event.filters structure to { key: value } for useFilter
    const newFilters = Object.keys(filters).reduce(
        (acc: Record<string, any>, key) => {
            const filter = filters[key];
            if (filter) {
                acc[key] = filter.value;
            }
            return acc;
        },
        {},
    );
    if (Object.keys(newFilters).length > 0) {
        updateFilters(newFilters); // Call updateFilters with the transformed object
    }
};
</script>
