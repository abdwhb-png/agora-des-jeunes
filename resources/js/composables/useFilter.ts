import { ref, computed, watch, onMounted, onUnmounted, readonly } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import type { Page } from "@inertiajs/core";
import { toast } from "vue-sonner";
import throttle from "lodash/throttle";
import debounce from "lodash/debounce";
import pickBy from "lodash/pickBy";
import { useFilterStore } from "@/stores/filterStore"; // Import the Pinia store

// @ts-ignore - Ziggy's route typings might not be recognized
declare function route(name: string, params?: any): string;

interface UseFilterOptions {
    initialFilters?: Record<string, any>;
    filterName?: string | null; // Used as the key in the Pinia store
    filterKeys?: string[] | { label: string; key: string }[]; // Keys to initialize in the store
    throttleWait?: number;
    filterUrl?: string | null; // Specific URL for GET requests if not using named filters
    sortOptions?: {
        defaultSortField?: string;
        defaultSortDirection?: "asc" | "desc";
    };
    onSearched?: (page: Page) => void; // Callback on successful filter application
    onReseted?: (page: Page) => void; // Callback on successful filter reset
    clearOnUnmount?: boolean; // Option to clear store state when component unmounts
}

export function useFilter(options: UseFilterOptions = {}) {
    const {
        initialFilters = {},
        filterName = null, // Key for the store
        filterKeys = [],
        throttleWait = 500, // Increased default wait time
        filterUrl = null,
        sortOptions = {
            defaultSortField: "",
            defaultSortDirection: "asc",
        },
        onSearched,
        onReseted,
        clearOnUnmount = false, // Default to false, filters persist
    } = options;

    const page = usePage();
    const loading = ref(false);
    const filterStore = useFilterStore(); // Instantiate the store

    // --- Initialization and Cleanup ---
    onMounted(() => {
        // Initialize the state slice for this filterName in the store
        filterStore.initializeFilterState(
            filterName,
            initialFilters,
            filterKeys,
        );
    });

    onUnmounted(() => {
        // Optionally clear the state slice when the component using the composable unmounts
        if (clearOnUnmount) {
            filterStore.clearFilterState(filterName);
        }
    });

    // --- Computed properties reading from the store ---

    // Read-only computed ref for the current filters object from the store
    // Components will bind directly to this using v-model (e.g., v-model="filters.search")
    const filters = computed(() => filterStore.getFilters(filterName));

    // Computed ref for whether filters are active, derived from the store
    const hasFilters = computed(() => filterStore.hasFilters(filterName));

    // --- Sort State (remains local to the composable instance for now) ---
    // Could also be moved to the store if needed globally
    const sortState = ref({
        field: sortOptions.defaultSortField || "",
        direction: sortOptions.defaultSortDirection || "asc",
    });

    // --- Inertia Request Function (Internal) ---
    const send = (
        url: string,
        method: string,
        data: Record<string, any>,
        successCallback?: (page: Page) => void,
        onError?: (errors: Record<string, string>) => void,
    ) => {
        console.log(`[useFilter:${filterName || "default"}] Sending request:`, {
            url,
            method,
            data,
        });
        router.visit(url, {
            method: method as "get" | "post" | "put" | "patch" | "delete",
            data: pickBy(data, (value) => value !== null && value !== ""), // Send only non-null/empty
            preserveState: true,
            preserveScroll: true,
            onStart: () => (loading.value = true),
            onSuccess: (page) => {
                if (successCallback) successCallback(page);
            },
            onError: (errors) => {
                console.error(
                    `[useFilter:${filterName || "default"}] Submission failed:`,
                    errors,
                );
                toast("Erreur de filtrage", {
                    description: "Impossible d'appliquer les filtres.",
                });
                if (onError) onError(errors);
            },
            onFinish: () => {
                loading.value = false;
            },
        });
    };

    // --- Watcher for Store Filter Changes ---
    // The watcher now triggers the 'send' function when the relevant slice of the store changes.
    // Direct updates to the store (via v-model or updateFilters action) will trigger this.
    const stopWatch = watch(
        // Watch the computed ref derived from the store's state for this filterName
        () => filterStore.getFilters(filterName),
        debounce((newFiltersState) => {
            // Replaced throttle with debounce
            console.log(
                `[useFilter:${filterName || "default"}] Detected filter change:`,
                newFiltersState,
            );
            // Get only non-null/empty values for the request payload
            const submittableFilters =
                filterStore.getSubmittableFilters(filterName);

            // Determine URL
            const url = filterUrl
                ? filterUrl // Use specific URL if provided (for GET)
                : filterName
                  ? route("filter.store") // POST for named filters
                  : page.url; // Fallback to current page URL for GET

            const method = filterName ? "post" : "get";

            // Prepare data to send, explicitly defining potential properties
            let dataToSend: {
                type?: string | null;
                filters: Record<string, any>;
                sort?: string;
                direction?: "asc" | "desc";
            } = {
                filters: submittableFilters,
            };

            if (filterName) {
                dataToSend.type = filterName;
            }

            // Include sort state if sorting is active
            if (sortState.value.field) {
                dataToSend.sort = sortState.value.field;
                dataToSend.direction = sortState.value.direction;
            }

            // Pass the onSearched callback for filter changes
            send(url, method, dataToSend, onSearched);
        }, throttleWait),
        { deep: true }, // Deep watch is necessary for changes within the filters object
    );

    // --- Actions that modify the store ---

    // Update specific filters in the store
    const updateFilters = (
        filtersToUpdate: Record<string, any>,
        onSuccess?: () => void,
    ) => {
        filterStore.updateFilters(filterName, filtersToUpdate);
        // Watcher will automatically trigger the send function
    };

    // Reset filters in the store
    const resetFilters = () => {
        filterStore.resetFilters(filterName); // Action resets the store state

        // Determine URL for reset request
        const url = filterName
            ? route("filter.reset") // PATCH for named filters
            : filterUrl // Use specific URL if provided (for GET)
              ? filterUrl
              : page.url; // Fallback to current page URL for GET

        const method = filterName ? "patch" : "get";

        // Data for reset request
        const dataToSend = filterName
            ? { type: filterName } // Named reset only needs type
            : { filters: {} }; // GET reset sends empty filters

        // Send the reset request and trigger onReseted callback
        send(url, method, dataToSend, (page) => {
            toast("Filtres réinitialisés", {
                description: "Les filtres ont été réinitialisés avec succès.",
            });
            if (onReseted) onReseted(page);
        });
    };

    // Update sorting (modifies local sort state and triggers send)
    const updateSort = (
        sortField: string,
        sortOrder: number,
        onSuccess?: (page: Page) => void,
    ): void => {
        // Update local sort state
        sortState.value.field = sortField;
        sortState.value.direction = sortOrder === 1 ? "asc" : "desc";

        // Get current filters from store for the request
        const currentFilters = filterStore.getSubmittableFilters(filterName);

        // Determine URL (usually current page for sorting)
        const url = filterUrl ? filterUrl : page.url;

        // Prepare data including sort parameters and current filters, explicitly typed
        let dataToSend: {
            type?: string | null;
            filters: Record<string, any>;
            sort: string;
            direction: "asc" | "desc";
        } = {
            filters: currentFilters,
            sort: sortState.value.field,
            direction: sortState.value.direction,
        };

        // If it's a named filter context, include the type
        if (filterName) {
            dataToSend.type = filterName;
        }

        // Send the request (sorting is typically GET)
        send(url, "get", dataToSend, onSuccess);
    };

    // --- Return values ---
    // Expose store state via computed refs and actions to interact with the store
    return {
        // Use 'filters' directly in component templates (v-model="filters.search")
        filters, // This is the computed ref linked to the store slice
        loading: readonly(loading), // Readonly loading state
        hasFilters, // Computed boolean from store
        sortState: readonly(sortState), // Readonly sort state

        // Actions
        updateFilters, // Action to update store filters
        resetFilters, // Action to reset store filters and send request
        updateSort, // Action to update sort and send request
        stopWatchFilters: stopWatch, // Function to stop the watcher if needed
    };
}
