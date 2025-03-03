<template>
    <NotPermitted v-if="!$page.props.can.manageJobOffers" />
    <Card v-else>
        <template #title>
            <div class="flex justify-between">
                Offres d'emplois

                <button
                    class="btn btn-primary btn-outline"
                    @click="create = true"
                >
                    <i class="ki-outline ki-plus"></i>
                    Nouveau Job
                </button>
                <Dialog
                    v-model:visible="create"
                    modal
                    dismissable-mask
                    header="Ajouter un Job"
                    :style="{ width: '50rem' }"
                    :breakpoints="dialogBreakpoints"
                >
                    <CreateForm @created="create = false" />
                </Dialog>
            </div>
        </template>
        <template #content>
            <CustomDataTable
                :paginated="jobs"
                title="Liste des jobs"
                filterName="job_offers"
                :show-creation-date="true"
            >
                <Column style="width: 1%">
                    <template #body="{ data }">
                        <div class="flex gap-2">
                            <EditButton
                                dialog-header="Modifier un job"
                                :edit-component="EditForm"
                                :component-props="{ item: data }"
                            />
                            <DeleteButton
                                :delete-url="route('job.destroy', data.id)"
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
            </CustomDataTable>
        </template>
    </Card>
</template>

<script setup lang="ts">
import { LaravelPagination } from "@/types";
import { dialogBreakpoints } from "@/utils/helpers";
import { ref } from "vue";
import CreateForm from "./JobForm.vue";
import EditForm from "./JobForm.vue";
import EditButton from "@/Components/Tables/EditButton.vue";
import DeleteButton from "@/Components/Tables/DeleteButton.vue";

defineProps({
    jobs: { type: Object as () => LaravelPagination<any>, default: null },
});

const create = ref(false);
</script>
