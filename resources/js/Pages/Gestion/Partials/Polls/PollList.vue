<script setup lang="ts">
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useMainStore } from "@/stores/main";
import { FILTER_NAMES } from "@/constants";
import { LaravelPagination } from "@/types";
import { dialogBreakpoints } from "@/utils/helpers";

import BaseListComponent from "@/Components/Gestion/BaseListComponent.vue";
import PollFilters from "./PollFilters.vue";
import PollForm from "./PollForm.vue";
import ShowPoll from "./ShowPoll.vue";
import ChangeStatus from "@/Components/Tables/ChangeStatus.vue";

const props = defineProps({
    data: { type: Object as () => LaravelPagination<any>, default: null },
    filterName: String,
});

const page = usePage();
const mainStore = useMainStore();

// Reference to the base list component
const baseList = ref(null);

// State for the additional dialog to show poll details
const showDialog = ref(false);
const selectedItem = ref(null);

// Function to open the show poll dialog
const openShowDialog = (item: any) => {
    selectedItem.value = item;
    showDialog.value = true;
};
</script>

<template>
    <BaseListComponent
        ref="baseList"
        :paginated="mainStore.polls?.list"
        :filterName="mainStore.polls?.filter_name || FILTER_NAMES.polls"
        :title="'Liste des sondages'"
        :fetchFunction="(url) => mainStore.fetchPolls(url)"
        :editDialogTilte="(item: any) => item?.title || 'Sondage'"
        :showCreationDate="true"
        :showUpdateDate="true"
    >
        <!-- Filter -->
        <template #filter>
            <PollFilters
                :filterName="mainStore.polls?.filter_name"
                :data-filters="mainStore.polls?.filters"
                :publish-statuses="mainStore.publish_statuses"
                :validity-statuses="mainStore.validity_statuses"
            />
        </template>

        <!-- Dialog content slot -->
        <template #dialog-content="{ item, close }">
            <PollForm :item="item" @updated="close" @canceled="close" />
        </template>

        <!-- Additional dialogs -->
        <template #additional-dialogs>
            <Dialog
                v-model:visible="showDialog"
                @hide="selectedItem = null"
                modal
                dismissable-mask
                :header="selectedItem?.title"
                :style="{ width: '50rem' }"
                :breakpoints="dialogBreakpoints"
            >
                <ShowPoll v-if="selectedItem" :id="selectedItem.id" />
            </Dialog>
        </template>

        <!-- Action column override -->
        <template #action-column>
            <Column style="width: 1%">
                <template #body="{ data }">
                    <div class="flex gap-1">
                        <button
                            class="btn btn-sm btn-icon btn-clear btn-light"
                            @click="baseList.openDialog(data)"
                        >
                            <i class="ki-filled ki-notepad-edit"> </i>
                        </button>
                        <button
                            class="btn btn-sm btn-icon btn-clear btn-light"
                            @click="openShowDialog(data)"
                        >
                            <i class="ki-filled ki-eye"> </i>
                        </button>
                    </div>
                </template>
            </Column>
        </template>

        <!-- Content columns slot -->
        <template #content-columns>
            <Column
                field="published"
                sortable
                header="Publié"
                style="width: 5%"
            >
                <template #body="{ data, field }">
                    <ChangeStatus
                        :item="data"
                        :routeName="page.props.routePrefix + 'poll.update'"
                        :field="field"
                    />
                </template>
            </Column>

            <Column header="Sondage" style="width: 35%">
                <template #body="{ data }">
                    <div class="flex flex-col gap-2 mb-2">
                        <span
                            class="font-medium text-sm text-gray-900 underline"
                            >{{ data.title }}</span
                        >
                        <span
                            class="text-xs text-gray-700"
                            v-tooltip.bottom="data.description"
                        >
                            {{ data.description }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-semibold text-sky-500"
                            >Réponses enregistrées:
                            {{ data.responses_count || 0 }}</span
                        >
                    </div>
                </template>
            </Column>

            <Column header="Validité" style="width: 20%; min-width: 15rem">
                <template #body="{ data }">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-1">
                            <i class="ki-outline ki-calendar-8 text-sm"></i>
                            <span class="text-xs text-gray-600"
                                >Créé le:
                                {{
                                    data.created_at_formatted || data.created_at
                                }}</span
                            >
                        </div>
                        <div
                            class="flex items-center gap-1"
                            v-if="data.expiration_date"
                        >
                            <i class="ki-outline ki-calendar-tick text-sm"></i>
                            <span class="text-xs text-gray-600">
                                Expire le: {{ data.expiration_date_formatted }}
                            </span>
                        </div>
                        <div class="mt-1">
                            <span
                                class="badge badge-outline"
                                :class="
                                    data.is_expired
                                        ? 'badge-danger'
                                        : 'badge-success'
                                "
                            >
                                {{ data.is_expired ? "Expiré" : "Valide" }}
                            </span>
                        </div>
                    </div>
                </template>
            </Column>

            <Column
                field="is_public"
                header="Accessibilité"
                sortable
                style="width: 10%"
            >
                <template #body="{ data, field }">
                    <span
                        class="badge"
                        :class="data[field] ? 'badge-info' : 'badge-warning'"
                    >
                        {{ data[field] ? "Public" : "Privé" }}
                    </span>
                </template>
            </Column>
        </template>
    </BaseListComponent>
</template>
