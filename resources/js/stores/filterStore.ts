import { defineStore } from "pinia";
import { reactive, computed } from "vue";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";

// Helper to get a unique key for the store state
const getStoreKey = (filterName: string | null | undefined): string => {
    return filterName || "__DEFAULT__";
};

interface FilterState {
    [key: string]: any; // Represents filters for a specific key like 'search', 'status', etc.
}

interface StoreState {
    filters: Record<string, FilterState>; // Main state object, keyed by filterName or '__DEFAULT__'
}

export const useFilterStore = defineStore("filterStore", () => {
    // Use reactive for nested objects to ensure deep reactivity
    const state = reactive<StoreState>({
        filters: {},
    });

    // --- Getters (Computed properties) ---

    // Get filters for a specific filterName
    const getFilters = computed(() => (filterName: string | null) => {
        const key = getStoreKey(filterName);
        return state.filters[key] || {};
    });

    // Check if any filters are active for a specific filterName
    const hasFilters = computed(() => (filterName: string | null) => {
        const key = getStoreKey(filterName);
        const currentFilters = state.filters[key] || {};
        // Check if any value is not null or empty string
        return Object.values(currentFilters).some(
            (value) => value !== null && value !== "",
        );
    });

    // Get filters ready for submission (non-null/empty values)
    const getSubmittableFilters = computed(
        () => (filterName: string | null) => {
            const key = getStoreKey(filterName);
            const currentFilters = state.filters[key] || {};
            return pickBy(
                currentFilters,
                (value) => value !== null && value !== "",
            );
        },
    );

    // --- Actions ---

    // Initialize or update the filter state for a specific filterName
    function initializeFilterState(
        filterName: string | null,
        initialFilters: Record<string, any> = {},
        filterKeys: string[] | { key: string; label: string }[] = [],
    ) {
        const key = getStoreKey(filterName);
        if (!state.filters[key]) {
            // Set initial values
            state.filters[key] = { ...initialFilters };

            // Ensure all defined filterKeys (and 'search') exist, defaulting to null
            const allKeys = new Set<string>(["search"]); // Always include search
            filterKeys.forEach((k) => {
                const actualKey = typeof k === "object" ? k.key : k;
                allKeys.add(actualKey);
            });

            allKeys.forEach((k) => {
                if (!(k in state.filters[key])) {
                    state.filters[key][k] = null;
                }
            });
            console.log(
                `Initialized filters for key "${key}":`,
                state.filters[key],
            );
        }
    }

    // Update specific filters for a filterName
    function updateFilters(
        filterName: string | null,
        filtersToUpdate: Record<string, any>,
    ) {
        const key = getStoreKey(filterName);
        if (!state.filters[key]) {
            // Initialize if accessed before initialization (might happen)
            console.warn(
                `Filters for key "${key}" accessed before initialization during update. Initializing.`,
            );
            initializeFilterState(filterName, filtersToUpdate); // Initialize with the update data
        } else {
            // Merge updates into existing state
            Object.keys(filtersToUpdate).forEach((filterKey) => {
                state.filters[key][filterKey] = filtersToUpdate[filterKey];
            });
            console.log(
                `Updated filters for key "${key}":`,
                state.filters[key],
            );
        }
    }

    // Reset filters for a filterName
    function resetFilters(filterName: string | null) {
        const key = getStoreKey(filterName);
        if (state.filters[key]) {
            // Reset all keys within this filter group to null
            state.filters[key] = mapValues(state.filters[key], () => null);
            console.log(`Reset filters for key "${key}":`, state.filters[key]);
        } else {
            console.warn(
                `Attempted to reset non-existent filters for key "${key}".`,
            );
        }
    }

    // Remove filter state completely for a filterName (e.g., on component unmount)
    function clearFilterState(filterName: string | null) {
        const key = getStoreKey(filterName);
        if (state.filters[key]) {
            delete state.filters[key];
            console.log(`Cleared filter state for key "${key}".`);
        }
    }

    return {
        // State (though direct access is discouraged, use getters)
        // _state: state, // For debugging if needed

        // Getters
        getFilters,
        hasFilters,
        getSubmittableFilters,

        // Actions
        initializeFilterState,
        updateFilters,
        resetFilters,
        clearFilterState,
    };
});
