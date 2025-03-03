<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Liens de réseaux sociaux</h3>
        </div>
        <div class="card-body">
            <Message severity="secondary" closable
                >Les élément sans lien ne seront pas affichés.</Message
            >

            <DataTable
                :value="social_links"
                v-model:editingRows="editingRows"
                editMode="row"
                dataKey="id"
                @row-edit-save="onRowEditSave"
                :pt
            >
                <Column
                    :rowEditor="true"
                    style="width: 10%"
                    bodyStyle="text-align:center"
                ></Column>

                <Column field="platform" header="Plateforme" style="width: 30%">
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" fluid />
                    </template>
                </Column>

                <Column field="url" header="URL" style="width: 60%">
                    <template #editor="{ data, field }">
                        <InputText v-model="data[field]" fluid />
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useToast } from "primevue/usetoast";
import { pt } from "@/utils/dataTable";

defineProps({
    social_links: Object,
});

const page = usePage();
const toast = useToast();

const editingRows = ref([]);
const form = useForm({});

const onRowEditSave = (event) => {
    const { data, index, newData } = event;

    if (data.platform == newData.platform && data.url == newData.url) return;

    form.transform((data) => {
        return { platform: newData.platform, url: newData.url };
    }).put(route(page.props.routePrefix + "social-link.update", data.id), {
        preserveScroll: true,
        onSuccess: (page) => {
            toast.add({
                severity: "success",
                summary: page.props.flash.status,
                life: 5000,
            });
        },
    });
};
</script>
