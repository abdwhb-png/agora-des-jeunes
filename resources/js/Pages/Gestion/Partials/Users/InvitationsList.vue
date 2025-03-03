<template>
    <CustomDataTable
        title="Liste des invitations"
        :paginated="paginated"
        filterName="users_invitations"
    >
        <Column sort-field="email" sortable header="Invité" style="width: 30%">
            <template #body="{ data }">
                <div class="flex flex-col gap-2">
                    <span class="text-xs text-gray-700 font-normal">
                        {{ data.name }}
                    </span>
                    <a
                        class="leading-none font-medium text-sm text-gray-900 hover:text-primary"
                        href="#"
                    >
                        <CopyBtn :text="data.email" />
                        {{ data.email }}
                    </a>
                </div>
            </template>
        </Column>
        <Column field="link" header="Lien" style="width: 15%">
            <template #body="{ data, field }">
                <div class="flex flex-col gap-2">
                    <div class="max-w-56 truncate">
                        <a class="text-sm link" href="#">
                            <CopyBtn :text="data[field]" />
                            {{ data[field] }}
                        </a>
                    </div>
                    <Button
                        label="Renvoyer l'invitation"
                        :loading="data.loading"
                        size="small"
                        severity="info"
                        outlined=""
                        @click="resendInvitation(data)"
                    />
                </div>
            </template>
        </Column>
        <Column header="Statut" style="width: 35%">
            <template #body="{ data }">
                <div class="grid grid-cols-3 gap-1">
                    <span class="col-span-3">
                        <b>Expire le </b>
                        {{
                            dayjs(data.expires_at).format(
                                "DD/MM/YYYY à HH:mm:ss",
                            )
                        }}
                    </span>
                    <div class="col-span-3">
                        <Tag
                            :value="
                                data.is_used
                                    ? 'Déja utilisé'
                                    : 'Pas encore utilisé'
                            "
                            :severity="data.is_used ? 'success' : 'secondary'"
                        />
                    </div>
                </div>
            </template>
        </Column>
        <Column
            field="created_at"
            header="Date de création"
            sortable
            style="width: 20%"
        >
            <template #body="{ data, field }">
                {{ dayjs(data[field]).format("DD/MM/YYYY à HH:mm:ss") }}
            </template>
        </Column>
    </CustomDataTable>
</template>

<script setup>
import dayjs from "dayjs";
import { watch, ref } from "vue";
import { useToast } from "primevue/usetoast";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    data: Object,
});

const paginated = ref([]);

const toast = useToast();

const resendInvitation = (item) => {
    router.post(
        route("user.invite"),
        {
            name: item.name,
            email: item.email,
        },
        {
            preserveScroll: true,
            only: ["users_invitations"],
            onStart: () => {
                item.loading = true;
            },
            onSuccess: () => {
                toast.add({
                    severity: "success",
                    summary: "Invitation renvoyée à " + item.email,
                    life: 5000,
                });
            },
            onFinish: () => {
                item.loading = false;
            },
        },
    );
};

watch(
    () => props.data,
    (newData) => {
        paginated.value = newData;
    },
    { immediate: true, deep: true },
);
</script>
