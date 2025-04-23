<script setup lang="ts">
import { ref } from "vue";
import { useMainStore } from "@/stores/main";
import { FILTER_NAMES } from "@/constants";
import { LaravelPagination } from "@/types";

import BaseListComponent from "@/Components/Gestion/BaseListComponent.vue";
import TrainingForm from "./TrainingForm.vue";

defineProps({
    data: { type: Object as () => LaravelPagination<any>, default: null },
    filterName: String,
});

const mainStore = useMainStore();
const baseList = ref(null);
</script>

<template>
    <BaseListComponent
        ref="baseList"
        :paginated="mainStore.trainings?.list"
        :filter-name="
            mainStore.trainings?.filter_name || FILTER_NAMES.trainings
        "
        :title="'Formations'"
        :fetchFunction="(url: string) => mainStore.fetchJobOffers(url)"
        :editDialogTitle="(item: any) => item?.question || 'Modifier une FAQ'"
        :showDeleteButton="true"
        :getDeleteUrl="(item: any) => route('training.destroy', item.id)"
        :getElementName="(item: any) => `l'offre d'emploi ${item.title}`"
        :showCreationDate="true"
        :showUpdateDate="true"
    >
        <!-- Dialog content slot -->
        <template #dialog-content="{ item, close }">
            <TrainingForm :item="item" @updated="close" @canceled="close" />
        </template>

        <!-- Content columns slot -->
        <template #content-columns>
            <Column header="Formation">
                <template #body="{ data }">
                    <div class="flex flex-col gap-0.5 max-w-[80%]">
                        <CopyBtn
                            :text="data.title"
                            class="leading-none font-medium text-sm text-gray-900"
                        />
                        <span
                            class="text-xs text-gray-700 font-normal truncate"
                        >
                            <i class="ki-duotone ki-geolocation"></i>
                            {{ data.location }}
                        </span>
                    </div>
                </template>
            </Column>
            <Column field="description" header="Description">
                <template #body="{ data, field }">
                    <div v-html="data[field]"></div>
                </template>
            </Column>
            <Column header="Détails">
                <template #body="{ data }">
                    <div class="flex flex-col gap-0.5 text-xs">
                        <span class="text-gray-700 font-normal">
                            <b>Date de début:</b> {{ data.start_date }}
                        </span>
                        <span class="text-gray-700 font-normal">
                            <b>Date de fin:</b> {{ data.end_date }}
                        </span>
                    </div>
                </template>
            </Column>
        </template>
    </BaseListComponent>
</template>
