<template>
    <div
        class="flex flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium"
        :class="[
            sizeClass,
            showItemsSelection ? 'justify-between' : 'justify-center',
        ]"
    >
        <!-- Items per page selection -->
        <div
            class="flex items-center gap-2 order-2 md:order-1"
            v-if="showItemsSelection"
        >
            Items par page
            <Select
                class="w-40"
                size="small"
                v-model="form.filters.per_page"
                @change="updatePagination"
                :options="itemsPerPage"
                editable
                :disabled="loading || !paginatedMeta?.total"
            />
        </div>

        <!-- Boutons de pagination -->
        <div
            class="flex flex-wrap justify-center items-center gap-4 order-1 md:order-2"
        >
            <span data-datatable-info="true">{{ paginationInfo }}</span>
            <!-- Use simple pagination buttons -->
            <PaginationBtns
                :meta="paginatedMeta"
                :filtered-links="filteredLinks"
                :http-request="httpRequest"
                @page-change="emits('update:page', { url: $event })"
            />
        </div>
    </div>
</template>

<script setup lang="ts">
import { useForm, router } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";
import { LaravelPagination } from "@/types";
import { itemsPerPage } from "@/utils";
import PaginationBtns from "./PaginationBtns.vue";

// Constants
const PAGE_LINKS_OFFSET = 1; // Skip "prev" and "next" links
const DEFAULT_PAGE = 1;

const emits = defineEmits(["update:itemsPerPage", "update:page"]);

const props = defineProps({
    paginated: {
        type: Object as () => LaravelPagination<any>,
        required: false,
        default: {},
    },
    filterName: {
        type: String,
        required: false,
        default: null,
    },
    dataFilters: Object,
    showItemsSelection: {
        type: Boolean,
        default: true,
    },
    httpRequest: {
        type: Boolean,
        required: false,
    },
    sizeClass: String,
});

const loading = ref(false);
const paginatedMeta = ref<Partial<LaravelPagination<any>>>({});
const error = ref<string | null>(null);

// Function to get current per_page with proper fallback
function getCurrentPerPage() {
    return (
        props.dataFilters?.[props.filterName]?.per_page ||
        props.paginated?.per_page ||
        itemsPerPage[0]
    ); // Default value
}

// Make the form reactive to prop changes with a function
const form = useForm(() => ({
    type: props.filterName,
    filters: {
        per_page: getCurrentPerPage(),
    },
}));

// Rename for clarity - handles both page changes and items per page changes
const updatePagination = (page?: number) => {
    form.post(route("filter.store"), {
        preserveScroll: true,
        preserveState: true,
        onStart: () => {
            loading.value = true;
            error.value = null;
        },
        onSuccess: () => {
            loading.value = false;
            emits("update:itemsPerPage", form.filters.per_page);
        },
        onError: (errors) => {
            loading.value = false;
            error.value = "Échec de la mise à jour de la pagination";
        },
        onFinish: () => {
            loading.value = false;
            if (props.paginated.current_page > props.paginated.last_page) {
                const url = filteredLinks.value?.at(-1)?.url;
                if (url) router.get(url);
            }
        },
    });
};

watch(
    () => props.paginated,
    () => {
        if (props.paginated) {
            const { data, ...meta } = props.paginated;
            paginatedMeta.value = meta;

            // Update form when paginated data changes
            form.filters.per_page = getCurrentPerPage();
        }
    },
    { immediate: true },
);

// Calcul des indices de début et de fin des éléments affichés
const paginationInfo = computed(() => {
    if (!paginatedMeta.value?.total) return "0 à 0 de 0";
    return `${paginatedMeta.value.from} à ${paginatedMeta.value.to} de ${paginatedMeta.value.total}`;
});

// Filtrer les liens de pagination pour exclure "Précédent" et "Suivant"
const filteredLinks = computed(() => paginatedMeta.value?.links?.slice(1, -1));
</script>
