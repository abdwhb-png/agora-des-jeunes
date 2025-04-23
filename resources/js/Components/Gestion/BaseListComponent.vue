<script setup lang="ts">
import { ref, computed, reactive, onMounted } from "vue";
import { dialogBreakpoints } from "@/utils/helpers";
import { LaravelPagination } from "@/types";
import { toast } from "vue-sonner";
import DeleteButton from "@/Components/Tables/DeleteButton.vue"; // Added import

const props = defineProps({
    // Common props
    paginated: { type: Object as () => LaravelPagination<any>, default: null },
    filterName: String,
    title: { type: String, required: true },
    // Function to fetch data
    fetchFunction: { type: Function, required: true },
    // Dialog props
    editDialogTitle: {
        type: Function,
        default: (item: any) =>
            item?.title || item?.theme || item?.question || "Modification",
    },
    // Additional configuration
    showCreationDate: { type: Boolean, default: true },
    showUpdateDate: { type: Boolean, default: true },
    dialogWidth: { type: String, default: "50rem" },
    cacheEnabled: { type: Boolean, default: true },
    cacheDuration: { type: Number, default: 5 * 60 * 1000 }, // 5 minutes
    filters: { type: Object, default: () => ({}) },
    dataFilters: { type: Object, default: () => ({}) },
    showPagination: { type: Boolean, default: true }, // Added to control pagination visibility
    // Delete button props
    showDeleteButton: { type: Boolean, default: false },
    getDeleteUrl: { type: Function, default: (item: any) => null },
    getElementName: { type: Function, default: (item: any) => "cet élément" },
});

const emit = defineEmits([
    "item-selected",
    "refresh-data",
    "page-change",
    "per-page-change",
]);

// State management
const loading = ref(false);
const error = ref<string | null>(null);
const data = ref([]);
const currentUrl = ref<string | null>(null);

function handleUrlChange(event: any) {
    if (event && event.url) {
        currentUrl.value = event.url;
        loadData(true);
        emit("page-change", event.url);
    }
}

// Dialog state management
const dialogState = reactive({
    visible: false,
    item: null as any | null,
});

// Data caching
const lastLoadTime = ref<number | null>(null);

// Computed property for data source
const items = computed(() => props.paginated || data.value);

// Open dialog for editing
function openDialog(item: any) {
    dialogState.item = item;
    dialogState.visible = true;
    emit("item-selected", item);
}

// Close dialog and refresh if needed
function closeDialog() {
    dialogState.visible = false;

    // Keep the item data briefly for transition
    setTimeout(() => {
        dialogState.item = null;
    }, 300);

    if (!props.paginated) {
        loadData();
    }
    emit("refresh-data");
}

// Load data from the provided fetch function
async function loadData(force = false) {
    if (!force) {
        // Skip if data is provided externally
        if (props.paginated) return;

        // Skip if using cache and data is recent enough
        if (
            props.cacheEnabled &&
            lastLoadTime.value &&
            Date.now() - lastLoadTime.value < props.cacheDuration
        ) {
            return;
        }
    }
    try {
        error.value = null;
        loading.value = true;

        // Pass the currentUrl to fetchFunction if available
        const result = await props.fetchFunction(currentUrl.value);

        data.value = result; // Store the returned data
        lastLoadTime.value = Date.now();
    } catch (err) {
        console.error(`Error loading data:`, err);
        error.value = "Impossible de charger les données. Veuillez réessayer.";
        toast("Erreur", {
            description:
                "Une erreur est survenue lors du chargement des données.",
        });
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    if (!props.paginated) loadData();
});

// Expose methods for the parent component
defineExpose({
    loadData,
    openDialog,
    closeDialog,
    dialogState,
    loading,
    error,
});
</script>

<template>
    <!-- Error alert if needed -->
    <div class="mb-4 flex items-center justify-between gap-2">
        <Message v-if="error" severity="error" size="small" closable>{{
            error
        }}</Message>
        <button @click="loadData(true)" class="ml-2 btn btn-sm btn-light">
            <i class="ki-filled ki-arrow-circle-right"></i>
            Raffraîchir
        </button>
    </div>

    <!-- Edit Dialog - Slot for custom form -->
    <Dialog
        v-model:visible="dialogState.visible"
        modal
        @hide="dialogState.item = null"
        :header="editDialogTitle(dialogState.item)"
        :style="{ width: dialogWidth }"
        :breakpoints="dialogBreakpoints"
    >
        <slot
            name="dialog-content"
            :item="dialogState.item"
            :close="closeDialog"
        ></slot>
    </Dialog>

    <!-- Additional dialogs if needed -->
    <slot name="additional-dialogs" :item="dialogState.item"></slot>

    <!-- Data Table -->
    <CustomDataTable
        :paginated="items"
        :loading="loading"
        :title="title"
        :filter-name="filterName"
        :filters="filters"
        :show-creation-date="showCreationDate"
        :show-update-date="showUpdateDate"
        :show-pagination="false"
        :http-request="true"
        @filtered="loadData(true)"
        @update:page="handleUrlChange"
    >
        <template #filter>
            <slot name="filter"></slot>
        </template>

        <!-- Default action column -->
        <Column style="width: 1%" v-if="!$slots['action-column']">
            <template #body="{ data }">
                <div class="flex items-center gap-1">
                    <!-- Added wrapper for layout -->
                    <!-- Edit button -->
                    <button
                        class="btn btn-sm btn-icon btn-clear btn-light"
                        @click="openDialog(data)"
                    >
                        <i class="ki-filled ki-notepad-edit"></i>
                    </button>
                    <!-- Delete button -->
                    <DeleteButton
                        v-if="showDeleteButton"
                        :delete-url="getDeleteUrl(data)"
                        :element-name="getElementName(data)"
                        @deleted="loadData(true)"
                    />
                </div>
            </template>
        </Column>

        <!-- Optional custom action column -->
        <slot name="action-column"></slot>

        <!-- Status column (often shared) -->
        <slot name="status-column"></slot>
        <!-- Content columns - completely customizable -->
        <slot name="content-columns"></slot>
    </CustomDataTable>

    <!-- Custom Pagination -->
    <div
        v-if="showPagination"
        class="flex flex-col md:flex-row gap-5 items-center justify-between py-3 px-0"
    >
        <Pagination
            :paginated="items"
            :filter-name="filterName"
            :data-filters="$page.props.filters"
            :http-request="true"
            @update:page="handleUrlChange"
            @update:itemsPerPage="loadData(true)"
        />
    </div>
</template>
