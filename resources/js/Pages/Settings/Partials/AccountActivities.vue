<template>
    <CustomDataTable
        :paginated="paginated"
        filterName="account_activities"
        :show-creation-date="false"
        :show-update-date="false"
    >
        <Column field="event" header="Evènement">
            <template #body="{ data, field }">
                <span class="leading-none font-semibold text-gray-700">
                    {{ data[field] }}</span
                >
            </template>
        </Column>
        <Column field="severity" header="Importance">
            <template #body="{ data, field }">
                <span
                    class="badge badge-sm badge-outline capitalize"
                    :style="{
                        color: data[field]?.color,
                        borderColor: data[field]?.color,
                    }"
                >
                    {{ data[field]?.value }}
                </span>
            </template>
        </Column>
        <Column
            field="description"
            header="Description"
            class="text-gray-500 font-normal"
        />
        <Column field="ip_address" header="Adresse IP" />
        <Column field="created_at" header="Date">
            <template #body="{ data, field }">
                <span class="text-gray-500 font-normal">{{ data[field] }}</span>
            </template>
        </Column>
    </CustomDataTable>
</template>

<script lang="ts">
export default {
    name: "AccountActivities",
};
</script>

<script setup lang="ts">
import dayjs from "dayjs";
import { LaravelPagination } from "@/types";

const props = defineProps({
    paginated: {
        type: Object as () => LaravelPagination<any>,
        required: true,
    },
});
</script>
