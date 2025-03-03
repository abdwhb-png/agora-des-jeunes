<script setup lang="ts">
import { useMainStore } from "@/stores/main";
import { ref, onMounted } from "vue";
import { dialogBreakpoints } from "@/utils/helpers";
import { LaravelPagination } from "@/types";
import { FilterMatchMode } from "@primevue/core/api";
import FaqForm from "./FaqForm.vue";

import ChangeStatus from "@/Components/Tables/ChangeStatus.vue";

const props = defineProps({
    data: { type: Object as () => LaravelPagination<any>, default: null },
    filterName: String,
});

const mainStore = useMainStore();
const loading = ref(false);

const filters = ref({
    category: { value: null, matchMode: FilterMatchMode.EQUALS },
});

const item = ref(null);
const edit = ref(false);

const onClose = () => {
    if (!props.data) {
        loadData();
    }
    edit.value = false;
};

onMounted(() => {
    if (!props.data) loadData();
    mainStore.fetchFeatures();
});

async function loadData() {
    loading.value = true;
    await mainStore.fetchFaqs().then(() => {
        loading.value = false;
    });
}
</script>

<template>
    <Dialog
        v-model:visible="edit"
        modal
        @hide="item = null"
        :header="'Modifier un faq'"
        :style="{ width: '50rem' }"
        :breakpoints="dialogBreakpoints"
    >
        <FaqForm :item="item" @close="onClose()" />
    </Dialog>

    <CustomDataTable
        :paginated="data || mainStore.faqs"
        :filter-name="filterName"
        title="Questions/Réponses"
        :filters="filters"
        :loading="loading"
        :show-creation-date="true"
        :show-update-date="true"
        @searched="loadData()"
    >
        <Column style="width: 1%">
            <template #body="{ data }">
                <button
                    class="btn btn-sm btn-icon btn-clear btn-light"
                    @click="
                        item = data;
                        edit = true;
                    "
                >
                    <i class="ki-filled ki-notepad-edit"> </i>
                </button>
            </template>
        </Column>
        <Column field="is_active" sortable header="Publié" style="width: 10%">
            <template #body="{ data, field }">
                <ChangeStatus
                    :item="data"
                    :routeName="$page.props.routePrefix + 'faq.update'"
                    :field="field"
                />
            </template>
        </Column>

        <Column field="category" sortable header="Catégorie">
            <template #filter="{ filterModel, filterCallback }">
                <Select
                    v-model="filterModel.value"
                    :options="mainStore.appFeatures"
                    optionLabel="name"
                    optionValue="name"
                    @change="filterCallback()"
                    placeholder="Chercher une catégorie"
                />
            </template>
        </Column>

        <Column header="Question/Réponse">
            <template #body="{ data }">
                <div class="flex flex-col gap-1">
                    <a class="font-medium text-sm text-gray-900" href="#">
                        <CopyBtn :text="data.question" />
                        {{ data.question }}
                    </a>
                    <span
                        class="text-xs text-gray-700 font-normal max-w-[300px] truncate"
                        v-tooltip.bottom="data.answer"
                    >
                        {{ data.answer }}
                    </span>
                </div>
            </template>
        </Column>
        <Column field="is_active" header="Publié">
            <template #body="{ data, field }">
                <Tag
                    :severity="data[field] ? 'success' : 'secondary'"
                    :value="data[field] ? 'Oui' : 'Non'"
                />
            </template>
        </Column>
    </CustomDataTable>
</template>
