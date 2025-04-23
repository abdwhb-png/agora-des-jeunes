<script setup lang="ts">
import { ref } from "vue";
import { useMainStore } from "@/stores/main";
import { FILTER_NAMES } from "@/constants";
import { LaravelPagination } from "@/types";
import { FilterMatchMode } from "@primevue/core/api";

import BaseListComponent from "@/Components/Gestion/BaseListComponent.vue";
import JobForm from "./JobForm.vue";

defineProps({
    data: { type: Object as () => LaravelPagination<any>, default: null },
    filterName: String,
});

const mainStore = useMainStore();
const baseList = ref(null);

// Define filters
const filters = ref({
    // category: { value: null, matchMode: FilterMatchMode.EQUALS },
});
</script>

<template>
    <BaseListComponent
        ref="baseList"
        :paginated="mainStore.jobOffers?.list"
        :filter-name="
            mainStore.jobOffers?.filter_name || FILTER_NAMES.jobOffers
        "
        :title="'Offres d\'emplois'"
        :filters="filters"
        :fetchFunction="(url: string) => mainStore.fetchJobOffers(url)"
        :editDialogTitle="(item: any) => item?.question || 'Modifier une FAQ'"
        :showDeleteButton="true"
        :getDeleteUrl="(item: any) => route('job-offer.destroy', item.id)"
        :getElementName="(item: any) => `l'offre d'emploi ${item.title}`"
        :showCreationDate="true"
        :showUpdateDate="true"
    >
        <!-- Dialog content slot -->
        <template #dialog-content="{ item, close }">
            <JobForm :item="item" @close="close" />
        </template>

        <!-- Content columns slot -->
        <template #content-columns>
            <Column header="Infos du Job" style="width: 30%">
                <template #body="{ data }">
                    <div class="flex flex-col gap-0.5">
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
                    <div class="flex flex-col gap-0.5 max-w-[80%] text-xs">
                        <span class="text-gray-700 font-normal truncate">
                            <b>Salaire:</b> {{ data.salary_range }}
                        </span>
                        <div>
                            <b>Lien:</b>
                            <a
                                class="link text-sm truncate"
                                :href="data.application_link"
                                target="_blank"
                            >
                                <CopyBtn :text="data.application_link" />
                                {{ data.application_link ?? "--" }}
                            </a>
                        </div>
                    </div>
                </template>
            </Column>
        </template>
    </BaseListComponent>
</template>
