<script setup lang="ts">
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useMainStore } from "@/stores/main";
import { FILTER_NAMES } from "@/constants";
import { LaravelPagination } from "@/types";

import BaseListComponent from "@/Components/Gestion/BaseListComponent.vue";
import UpdateForm from "./AgoraForm.vue";
import ChangeStatus from "@/Components/Tables/ChangeStatus.vue";
import CopyBtn from "@/Components/CopyBtn.vue";

defineProps({
    data: { type: Object as () => LaravelPagination<any>, default: null },
    filterName: String,
});

const page = usePage();
const mainStore = useMainStore();

// Reference to the base list component
const baseList = ref(null);
</script>

<template>
    <BaseListComponent
        ref="baseList"
        :paginated="mainStore.agoraSessions?.list"
        :filterName="
            mainStore.agoraSessions?.filter_name || FILTER_NAMES.agoraSessions
        "
        :title="'Liste des sessions d\'Agora'"
        :fetchFunction="(url: string) => mainStore.fetchAgora(url)"
        :editDialogTilte="(item: any) => item?.theme || 'Session d\'Agora'"
        :showCreationDate="true"
        :showUpdateDate="true"
    >
        <!-- Dialog content slot -->
        <template #dialog-content="{ item, close }">
            <UpdateForm :item="item" @updated="close" @canceled="close" />
        </template>

        <!-- Content columns slot -->
        <template #content-columns>
            <Column
                field="published"
                sortable
                header="Statut"
                style="width: 10%"
            >
                <template #body="{ data, field }">
                    <ChangeStatus
                        :item="data"
                        :routeName="
                            page.props.routePrefix + 'agora-session.update'
                        "
                        :field="field"
                    />
                </template>
            </Column>

            <Column
                header="Session"
                sort-field="theme"
                sortable
                style="width: 20%"
            >
                <template #body="{ data }">
                    <div class="grid grid-cols-3 gap-1">
                        <CopyBtn
                            :text="data.theme"
                            class="col-span-3 font-medium text-sm text-gray-900 hover:text-primary"
                        />
                        <span
                            class="col-span-3 text-xs text-gray-700 font-normal truncate w-56"
                            v-tooltip.bottom="data.description"
                        >
                            {{ data.description }}
                        </span>
                        <div class="col-span-2">
                            <a
                                :href="data.image_url"
                                target="_blank"
                                class="btn btn-light btn-sm"
                                >Voir l'image</a
                            >
                        </div>
                    </div>
                </template>
            </Column>
            <Column
                field="participants"
                header="Participants"
                style="width: 10%"
            >
            </Column>
            <Column
                field="formated_date"
                header="Date Prévue"
                sortable
                style="width: 10%"
            >
            </Column>
        </template>
    </BaseListComponent>
</template>
