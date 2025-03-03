<template>
    <div
        class="card card-grid h-full"
        :style="{ maxWidth: false ? viewportWidth + 'px' : 'auto' }"
    >
        <div class="card-header">
            <SearchInput
                v-if="showSearch"
                :filter-name="filterName"
                placeholder="Rechercher..."
                @searched="onSearch"
            />
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
                        :value="Object.values(data)"
                        v-model:filters="filters"
                        filterDisplay="row"
                        scrollable
                        :scrollHeight
                        @filter="onFilter"
                    >
                        <template #empty>
                            <slot name="empty">
                                <div
                                    class="flex items-center grow rounded-xl border border-dashed gap-4 p-4 border-primary bg-secondary-light"
                                >
                                    <i
                                        class="ki-outline ki-information-1 text-3xl text-primary"
                                    >
                                    </i>
                                    <div class="flex flex-col gap-0.5">
                                        <p class="text text-2sm font-normal">
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
                                {{ data[field] }}
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
                                {{ data[field] }}
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
            <Pagination :paginated="paginated" :filterName="filterName" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { scrollHeight, pt } from "@/utils/dataTable";
import { LaravelPagination } from "@/types";
import { useViewport } from "@/composables/useViewport";
import { FilterMatchMode, FilterOperator } from "@primevue/core/api";
import dayjs from "dayjs";

defineOptions({
    inheritAttrs: false,
});

const { width: viewportWidth } = useViewport();

const emits = defineEmits(["searched"]);

const props = defineProps({
    title: {
        type: String,
        default: "Liste",
    },
    paginated: {
        type: Object as () => LaravelPagination<any> | LaravelPagination<any>,
        required: false,
        default: () => {},
    },
    filters: {
        type: Object,
        required: false,
        default: () => {},
    },
    filterName: {
        type: String,
        required: false,
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

const data = ref({});
const searchCount = ref(0);

const filters = ref();

const initFilters = () => {
    filters.value = {
        ...props.filters,
        created_at: { value: null, matchMode: FilterMatchMode.CONTAINS },
        updated_at: { value: null, matchMode: FilterMatchMode.CONTAINS },
    };
};
initFilters();

const onFilter = (event) => {
    // console.log(event.filters);
};

const onSearch = () => {
    searchCount.value++;
    emits("searched", searchCount.value);
};

const parseDate = (date) => {
    return date ? dayjs(date).format("DD/MM/YYYY à HH:mm:ss") : "--";
};

watch(
    () => props.paginated,
    () => {
        data.value =
            props.paginated?.data?.map((item) => {
                return {
                    ...item,
                    created_at: parseDate(item.created_at),
                    updated_at: parseDate(item.updated_at),
                };
            }) || {};
    },
    { immediate: true, deep: true },
);
</script>
