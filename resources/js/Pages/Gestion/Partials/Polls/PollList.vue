<script setup lang="ts">
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useMainStore } from "@/stores/main";
import { dialogBreakpoints } from "@/utils/helpers";
import { LaravelPagination } from "@/types";

import PollForm from "./PollForm.vue";
import ShowPoll from "./ShowPoll.vue";
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
const show = ref(false);

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
    await mainStore.fetchPolls().then(() => {
        loading.value = false;
    });
}
</script>

<template>
    <Dialog
        v-model:visible="edit"
        modal
        @hide="item = null"
        :header="item?.title"
        :style="{ width: '50rem' }"
        :breakpoints="dialogBreakpoints"
    >
        <PollForm :item="item" @updated="onClose" @canceled="onClose" />
    </Dialog>

    <Dialog
        v-model:visible="show"
        @hide="item = null"
        modal
        dismissable-mask
        :header="item?.title"
        :style="{ width: '50rem' }"
        :breakpoints="dialogBreakpoints"
    >
        <ShowPoll :id="item.id" />
    </Dialog>

    <CustomDataTable
        :paginated="data || mainStore.polls"
        filterName="filterName"
        title="Liste des sondages"
        :loading="loading"
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
                    :routeName="page.props.routePrefix + 'poll.update'"
                    :field="field"
                />
            </template>
        </Column>

        <Column sort-field="title" sortable header="Sondage" style="width: 20%">
            <template #body="{ data }">
                <div class="flex flex-col gap-2 max-w-56 mb-2">
                    <a
                        class="leading-none font-medium text-sm text-gray-900 hover:text-primary"
                        href="#"
                    >
                        <CopyBtn :text="data.title" />
                        {{ data.title }}
                    </a>
                    <span
                        class="text-xs text-gray-700 font-normal truncate"
                        v-tooltip.bottom="data.description"
                    >
                        {{ data.description }}
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-bold text-sky-500">
                        {{ data.total_votes }} votes
                    </span>
                    <button
                        class="btn btn-primary btn-outline btn-sm"
                        @click="
                            item = data;
                            show = true;
                        "
                    >
                        Voir Résultats
                    </button>
                </div>
            </template>
        </Column>
        <Column
            sort-field="is_expired"
            sortable
            header="Validité"
            style="width: 30%; min-width: 15rem"
        >
            <template #body="{ data }">
                <div class="grid grid-cols-3 gap-1">
                    <div class="col-span-3">
                        <Tag
                            :value="data.is_expired ? 'Expiré' : 'En cours'"
                            :severity="data.is_expired ? 'danger' : 'info'"
                        />
                    </div>
                    <span class="col-span-3 text-xs text-gray-700 font-normal">
                        <span class="font-bold">Commence le</span>
                        {{ data.debut ?? "--" }}
                    </span>
                    <span class="col-span-3 text-xs text-gray-700 font-normal">
                        <span class="font-bold">Fini le</span>
                        {{ data.fin ?? "--" }}
                    </span>
                </div>
            </template>
        </Column>
        <Column field="is_public" header="Public" sortable style="width: 10%">
            <template #body="{ data, field }">
                <span :class="`text-${data[field] ? 'primary' : 'gray-600'}`">{{
                    data[field] ? "Oui" : "Non"
                }}</span>
            </template>
        </Column>
    </CustomDataTable>
</template>
