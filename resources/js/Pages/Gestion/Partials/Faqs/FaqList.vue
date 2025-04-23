<script setup lang="ts">
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useMainStore } from "@/stores/main";
import { FILTER_NAMES } from "@/constants";
import { LaravelPagination } from "@/types";
import { FilterMatchMode } from "@primevue/core/api";

import BaseListComponent from "@/Components/Gestion/BaseListComponent.vue";
import FaqForm from "./FaqForm.vue";
import ChangeStatus from "@/Components/Tables/ChangeStatus.vue";

defineProps({
    data: { type: Object as () => LaravelPagination<any>, default: null },
    filterName: String,
});

const page = usePage();
const mainStore = useMainStore();

// Reference to the base list component
const baseList = ref(null);

// Define filters
const filters = ref({
    category: { value: null, matchMode: FilterMatchMode.EQUALS },
});

// Additional actions on mount
onMounted(() => {
    mainStore.fetchFeatures();
});
</script>

<template>
    <BaseListComponent
        ref="baseList"
        :paginated="mainStore.faqs?.list"
        :filter-name="mainStore.faqs?.filter_name || FILTER_NAMES.faqs"
        :title="'Questions/Réponses'"
        :fetchFunction="(url: string) => mainStore.fetchFaqs(url)"
        :editDialogTilte="(item: any) => item?.question || 'Modifier une FAQ'"
        :filters="filters"
        :showCreationDate="true"
        :showUpdateDate="true"
    >
        <!-- Dialog content slot -->
        <template #dialog-content="{ item, close }">
            <FaqForm :item="item" @close="close" />
        </template>

        <!-- Content columns slot -->
        <template #content-columns>
            <Column
                field="is_active"
                sortable
                header="Publié"
                style="width: 10%"
            >
                <template #body="{ data, field }">
                    <ChangeStatus
                        :item="data"
                        :routeName="page.props.routePrefix + 'faq.update'"
                        :field="field"
                    />
                </template>
            </Column>

            <Column
                field="category"
                sortable
                header="Catégorie"
                :show-filter-menu="false"
                style="width: 20%"
            >
                <template #filter="{ filterModel, filterCallback }">
                    <Select
                        placeholder="Chercher une catégorie"
                        v-model="filterModel.value"
                        :options="mainStore.appFeatures"
                        optionLabel="name"
                        optionValue="name"
                        :showClear="true"
                        @change="filterCallback()"
                    />
                </template>
            </Column>

            <Column header="Question/Réponse" style="width: 70%">
                <template #body="{ data }">
                    <div class="flex flex-col gap-1">
                        <div
                            class="font-medium text-sm text-gray-900 underline"
                        >
                            {{ data.question }}
                        </div>
                        <div
                            class="text-xs text-gray-700 truncate max-w-md"
                            v-tooltip.bottom="data.answer"
                        >
                            {{ data.answer }}
                        </div>
                    </div>
                </template>
            </Column>
        </template>
    </BaseListComponent>
</template>
