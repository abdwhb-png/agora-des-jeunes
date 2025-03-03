<template>
    <NotPermitted v-if="!$page.props.can.manageTrainings" />
    <Card v-else>
        <template #title>
            <div class="flex justify-between">
                Formations

                <button
                    class="btn btn-primary btn-outline"
                    @click="create = true"
                >
                    <i class="ki-outline ki-plus"></i>
                    Nouvelle Formation
                </button>
                <Dialog
                    v-model:visible="create"
                    modal
                    dismissable-mask
                    header="Ajouter une Formation"
                    :style="{ width: '50rem' }"
                    :breakpoints="dialogBreakpoints"
                >
                    <CreateForm @created="create = false" />
                </Dialog>
            </div>
        </template>
        <template #content>
            <CustomDataTable
                :paginated="trainings.list"
                title="Liste des formations"
                :filter-name="trainings.filter_name"
                :show-creation-date="true"
            >
                <Column style="width: 1%">
                    <template #body="{ data }">
                        <div class="flex gap-2">
                            <EditButton
                                :dialog-header="
                                    'Modifier la formation ' + data.title
                                "
                                :edit-component="EditForm"
                                :component-props="{ item: data }"
                            />
                            <DeleteButton
                                :delete-url="route('training.destroy', data.id)"
                            />
                        </div>
                    </template>
                </Column>
                <Column header="Infos du Job">
                    <template #body="{ data }">
                        <div class="flex flex-col gap-0.5 max-w-[80%]">
                            <a
                                class="leading-none font-medium text-sm text-gray-900 hover:text-primary truncate"
                                href="#"
                            >
                                <CopyBtn :text="data.title" />
                                {{ data.title }}
                            </a>
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
            </CustomDataTable>
        </template>
    </Card>
</template>

<script setup lang="ts">
import { CustomPaginatedData } from "@/types";
import { dialogBreakpoints } from "@/utils/helpers";
import { ref } from "vue";
import CreateForm from "./TrainingForm.vue";
import EditForm from "./TrainingForm.vue";
import EditButton from "@/Components/Tables/EditButton.vue";
import DeleteButton from "@/Components/Tables/DeleteButton.vue";

defineProps({
    trainings: { type: Object as () => CustomPaginatedData, required: true },
});

const create = ref(false);
</script>
