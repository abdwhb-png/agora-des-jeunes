<script setup>
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import HttpPaginationBtns from "./HttpPaginationBtns.vue";
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
    httpRequest: Boolean,
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
    <HttpPaginationBtns
        v-if="httpRequest"
        :meta="meta"
        :filtered-links="filteredLinks"
    />
    <Pagination
        v-else-if="meta"
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
                @click="$inertia.visit(meta?.first_page_url || '')"
            />
            <PaginationPrev
                @click="
                    meta?.prev_page_url
                        ? $inertia.visit(meta.prev_page_url)
                        : ''
                "
            />

            <template v-for="(item, index) in items">
                <PaginationListItem
                    v-if="item.type === 'page'"
                    :key="index"
                    :value="item.value"
                    as-child
                >
                    <UiButton
                        class="h-9 w-9 p-0"
                        :class="{
                            'cursor-not-allowed': isActive(item),
                        }"
                        :variant="isActive(item) ? 'default' : 'outline'"
                        as-child
                    >
                        <Link
                            preserve-scroll
                            preserve-state
                            prefetch
                            cache-for="1m"
                            :href="
                                findItem(item.value)?.url ||
                                route(route().current(), {
                                    ...route().params,
                                    page: item.value,
                                })
                            "
                        >
                            {{ item.value }}
                        </Link>
                    </UiButton>
                </PaginationListItem>
                <PaginationEllipsis v-else :key="item.type" :index="index" />
            </template>

            <PaginationNext
                @click="
                    meta?.next_page_url
                        ? $inertia.visit(meta.next_page_url)
                        : ''
                "
            />
            <PaginationLast
                @click="$inertia.visit(meta?.last_page_url || '')"
            />
        </PaginationList>
    </Pagination>
</template>
