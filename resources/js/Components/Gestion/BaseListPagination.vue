<script setup lang="ts">
import { ref, computed, watch } from "vue";
import { LaravelPagination } from "@/types";
import { router } from "@inertiajs/vue3";
import { itemsPerPage } from "@/utils/dataTable";

const props = defineProps({
    paginated: {
        type: Object as () => LaravelPagination<any>,
        required: true,
    },
    loading: {
        type: Boolean,
        default: false,
    },
    showItemsSelection: {
        type: Boolean,
        default: true,
    },
    maxVisiblePages: {
        type: Number,
        default: 5,
    },
    onPageChange: {
        type: Function,
        default: null,
    },
    onPerPageChange: {
        type: Function,
        default: null,
    },
});

const emit = defineEmits(["page-change", "per-page-change"]);

// Local state
const currentPerPage = ref(props.paginated?.per_page || itemsPerPage[0]);
const currentPage = ref(props.paginated?.current_page || 1);

// Watch for paginated changes to update local state
watch(
    () => props.paginated,
    (newVal) => {
        if (newVal) {
            currentPage.value = newVal.current_page || 1;
            currentPerPage.value = newVal.per_page || itemsPerPage[0];
        }
    },
    { immediate: true },
);

// Computed properties for pagination
const lastPage = computed(() => props.paginated?.last_page || 1);
const hasPrevPage = computed(() => currentPage.value > 1);
const hasNextPage = computed(() => currentPage.value < lastPage.value);
const totalItems = computed(() => props.paginated?.total || 0);
const from = computed(() => props.paginated?.from || 0);
const to = computed(() => props.paginated?.to || 0);

// Generate array of page numbers to display
const visiblePages = computed(() => {
    const pages = [];
    const halfMax = Math.floor(props.maxVisiblePages / 2);

    let startPage = Math.max(currentPage.value - halfMax, 1);
    let endPage = Math.min(
        startPage + props.maxVisiblePages - 1,
        lastPage.value,
    );

    if (endPage - startPage + 1 < props.maxVisiblePages) {
        startPage = Math.max(endPage - props.maxVisiblePages + 1, 1);
    }

    for (let i = startPage; i <= endPage; i++) {
        pages.push(i);
    }

    return pages;
});

// Navigation functions
function goToPage(page: number) {
    if (
        page === currentPage.value ||
        page < 1 ||
        page > lastPage.value ||
        props.loading
    ) {
        return;
    }

    currentPage.value = page;

    if (props.onPageChange) {
        props.onPageChange(page);
    } else {
        emit("page-change", page);
    }
}

function goToPrevPage() {
    if (hasPrevPage.value) {
        goToPage(currentPage.value - 1);
    }
}

function goToNextPage() {
    if (hasNextPage.value) {
        goToPage(currentPage.value + 1);
    }
}

function changePerPage(value: number) {
    if (value === currentPerPage.value || props.loading) {
        return;
    }

    currentPerPage.value = value;
    currentPage.value = 1; // Reset to first page

    if (props.onPerPageChange) {
        props.onPerPageChange(value);
    } else {
        emit("per-page-change", value);
    }
}
</script>

<template>
    <div
        class="flex flex-col md:flex-row gap-5 items-center justify-between py-3 px-0"
    >
        <!-- Items per page selection -->
        <div class="flex items-center gap-2" v-if="showItemsSelection">
            <span class="text-sm text-gray-600">Items par page:</span>
            <Select
                v-model="currentPerPage"
                :options="itemsPerPage"
                class="w-20"
                size="small"
                @change="changePerPage(currentPerPage)"
                :disabled="loading || !totalItems"
            />
        </div>

        <!-- Pagination info and controls -->
        <div class="flex items-center gap-4">
            <!-- Page info -->
            <div class="text-sm text-gray-600" v-if="totalItems > 0">
                {{ from }} à {{ to }} de {{ totalItems }}
            </div>

            <!-- Pagination controls -->
            <div class="flex items-center" v-if="lastPage > 1">
                <!-- First page button -->
                <button
                    class="btn btn-icon btn-sm btn-light me-1"
                    :disabled="currentPage === 1 || loading"
                    @click="goToPage(1)"
                >
                    <i class="ki-solid ki-double-left fs-6"></i>
                </button>

                <!-- Previous page button -->
                <button
                    class="btn btn-icon btn-sm btn-light me-1"
                    :disabled="!hasPrevPage || loading"
                    @click="goToPrevPage"
                >
                    <i class="ki-solid ki-left fs-6"></i>
                </button>

                <!-- Page numbers -->
                <div class="flex mx-1">
                    <button
                        v-for="page in visiblePages"
                        :key="page"
                        class="btn btn-icon btn-sm mx-0.5"
                        :class="
                            page === currentPage
                                ? 'btn-primary text-white'
                                : 'btn-light'
                        "
                        :disabled="loading || page === currentPage"
                        @click="goToPage(page)"
                    >
                        {{ page }}
                    </button>
                </div>

                <!-- Next page button -->
                <button
                    class="btn btn-icon btn-sm btn-light ms-1"
                    :disabled="!hasNextPage || loading"
                    @click="goToNextPage"
                >
                    <i class="ki-solid ki-right fs-6"></i>
                </button>

                <!-- Last page button -->
                <button
                    class="btn btn-icon btn-sm btn-light ms-1"
                    :disabled="currentPage === lastPage || loading"
                    @click="goToPage(lastPage)"
                >
                    <i class="ki-solid ki-double-right fs-6"></i>
                </button>
            </div>

            <!-- Loading indicator -->
            <div v-if="loading" class="ml-2">
                <i class="ki-solid ki-spinner ki-spin fs-6"></i>
            </div>
        </div>
    </div>
</template>
