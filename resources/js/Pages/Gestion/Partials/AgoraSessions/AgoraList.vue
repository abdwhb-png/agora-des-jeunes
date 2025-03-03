<script setup lang="ts">
import { ref, onMounted, onBeforeMount } from "vue";
import { usePage } from "@inertiajs/vue3";
import { dialogBreakpoints } from "@/utils/helpers";
import { useMainStore } from "@/stores/main";
import { LaravelPagination } from "@/types";

import UpdateForm from "./AgoraForm.vue";
import ChangeStatus from "@/Components/Tables/ChangeStatus.vue";

const props = defineProps({
    data: { type: Object as () => LaravelPagination<any>, default: null },
    filterName: String,
});

const page = usePage();
const mainStore = useMainStore();
const loading = ref(false);

const item = ref(null);
const edit = ref(false);

const onClose = () => {
    if (!props.data) {
        loadData();
    }
    edit.value = null;
};

onMounted(() => {
    if (!props.data) loadData();
});

async function loadData() {
    loading.value = true;
    await mainStore.fetchAgora().then(() => {
        loading.value = false;
    });
}
</script>

<template>
    <Dialog
        v-model:visible="edit"
        modal
        @hide="item = null"
        :header="item?.theme"
        :style="{ width: '50rem' }"
        :breakpoints="dialogBreakpoints"
    >
        <UpdateForm :item="item" @updated="onClose" @canceled="onClose" />
    </Dialog>

    <CustomDataTable
        :paginated="data || mainStore.agoraSessions"
        :loading="loading"
        title="Liste des sessions d'Agora"
        :filter-name="filterName"
        :show-creation-date="true"
        :show-update-date="true"
        @searched="loadData()"
    >
        <Column style="width: 1%">
            <template #body="{ data, field }">
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

        <Column field="published" sortable header="Publié" style="width: 10%">
            <template #body="{ data, field }">
                <ChangeStatus
                    :item="data"
                    :routeName="page.props.routePrefix + 'agora-session.update'"
                    :field="field"
                />
            </template>
        </Column>

        <Column header="Session" sort-field="theme" sortable style="width: 20%">
            <template #body="{ data, field }">
                <div class="grid grid-cols-3 gap-1">
                    <a
                        class="col-span-3 font-medium text-sm text-gray-900 hover:text-primary"
                        href="#"
                    >
                        <CopyBtn :text="data.theme" />
                        {{ data.theme }}
                    </a>
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
        <Column field="participants" header="Participants" style="width: 10%">
        </Column>
        <Column
            field="formated_date"
            header="Date Prévue"
            sortable
            style="width: 10%"
        >
        </Column>
    </CustomDataTable>
</template>
