<script setup>
import { DropdownMenuRadioItem } from "@/Components/ui/dropdown-menu";

defineProps({
    filterName: String,
    dataFilters: Object,
    publishStatuses: Object,
    validityStatuses: Object,
});

const filterKeys = [
    {
        key: "published",
        label: "Statut",
    },
    {
        key: "is_expired",
        label: "Validité",
    },
];
</script>

<template>
    <SearchFilter
        :filter-name="filterName"
        :data-filters="dataFilters"
        :filter-keys="filterKeys"
    >
        <template #publishedContent>
            <DropdownMenuRadioItem
                v-for="(value, index) in publishStatuses"
                :key="index"
                :value="value.toString()"
            >
                <Tag :value="index" :severity="value ? 'info' : 'danger'" />
            </DropdownMenuRadioItem>
        </template>
        <template #is_expiredContent>
            <DropdownMenuRadioItem
                v-for="(value, index) in validityStatuses"
                :key="index"
                :value="value.toString()"
            >
                <Tag :value="index" :severity="value ? 'info' : 'danger'" />
            </DropdownMenuRadioItem>
        </template>
    </SearchFilter>
</template>
