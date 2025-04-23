<script setup>
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from "@/Components/ui/pagination";

const emits = defineEmits(["page-change"]);

const props = defineProps({
    meta: { type: Object, default: () => ({}) },
    filteredLinks: { type: Array, default: () => [] },
});

const currentPage = ref(1);

const findItem = (value) => {
    return value
        ? props.filteredLinks?.find((item) => item.label === value.toString())
        : null;
};

const isActive = (item) =>
    item.value === currentPage.value || findItem(item.value)?.active;

watch(
    () => props.meta,
    () => {
        currentPage.value = props.meta?.current_page || 1;
    },
    { immediate: true },
);
</script>

<template>
    <Pagination
        v-if="meta"
        v-slot="{ page }"
        :items-per-page="meta.per_page"
        :total="meta.total"
        :sibling-count="1"
        show-edges
        :default-page="1"
    >
        <PaginationList
            v-slot="{ items }"
            class="flex items-center justify-center gap-1 pagination"
        >
            <PaginationFirst
                @click="emits('page-change', meta?.first_page_url)"
            />
            <PaginationPrev
                @click="emits('page-change', meta?.prev_page_url)"
            />

            <PaginationNext
                @click="emits('page-change', meta?.next_page_url)"
            />
            <PaginationLast
                @click="emits('page-change', meta?.last_page_url)"
            />
        </PaginationList>
    </Pagination>
</template>
