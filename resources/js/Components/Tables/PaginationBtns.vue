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
import { Link } from "@inertiajs/vue3"; // Ensure Link is imported if not already
import UiButton from "@/Components/ui/button/Button.vue"; // Assuming UiButton is imported like this

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

// New method to handle navigation based on httpRequest prop
const handleNavigation = (url) => {
    if (!url) return;
    if (props.httpRequest) {
        emits("page-change", url);
    } else {
        router.visit(url, { preserveState: true, preserveScroll: true });
    }
};

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
        :default-page="currentPage"
    >
        <PaginationList
            v-slot="{ items }"
            class="flex items-center justify-center gap-1 pagination"
        >
            <PaginationFirst @click="handleNavigation(meta?.first_page_url)" />
            <PaginationPrev @click="handleNavigation(meta?.prev_page_url)" />

            <template v-for="(item, index) in items">
                <PaginationListItem
                    v-if="item.type === 'page'"
                    :key="index"
                    :value="item.value"
                    as-child
                >
                    <UiButton
                        class="w-9 h-9 p-0"
                        :variant="item.value === page ? 'default' : 'outline'"
                        @click="
                            handleNavigation(
                                findItem(item.value)?.url ||
                                    route(route().current(), {
                                        ...route().params,
                                        page: item.value,
                                    }),
                            )
                        "
                    >
                        {{ item.value }}
                    </UiButton>
                </PaginationListItem>
                <PaginationEllipsis v-else :key="item.type" :index="index" />
            </template>

            <!-- Conditionally render page numbers and ellipsis only when not using http requests -->
            <template v-if="false && !httpRequest">
                <template v-for="(item, index) in items">
                    <PaginationListItem
                        v-if="item.type === 'page'"
                        :key="'page-' + index"
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
                    <PaginationEllipsis
                        v-else
                        :key="'ellipsis-' + index"
                        :index="index"
                    />
                </template>
            </template>
            <!-- Render ellipsis if using http requests and there are gaps -->
            <template v-else>
                <!-- Basic ellipsis logic for http mode if needed, or omit if not required -->
                <!-- This part might need adjustment based on how you want http mode to look -->
                <!-- For simplicity, we might omit page numbers/ellipsis in http mode -->
            </template>

            <PaginationNext @click="handleNavigation(meta?.next_page_url)" />
            <PaginationLast @click="handleNavigation(meta?.last_page_url)" />
        </PaginationList>
    </Pagination>
</template>
