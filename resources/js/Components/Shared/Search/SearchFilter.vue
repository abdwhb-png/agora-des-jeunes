<template>
    <div class="flex gap-2 pl-2">
        <Button
            v-if="hasFilters"
            class="btn btn-sm btn-outline btn-dark"
            unstyled
            @click="resetFilters"
            icon="ki-filled ki-cross"
            label="Réinitialiser"
        />
        <DropdownMenu v-if="showFilters">
            <DropdownMenuTrigger>
                <button
                    class="btn btn-xs btn-primary"
                    :class="hasFilters ? 'btn-dark' : 'btn-primary btn-outline'"
                >
                    {{ hasFilters ? "Filtres appliqués" : "Filtres" }}
                </button>
            </DropdownMenuTrigger>
            <DropdownMenuContent>
                <template v-for="(key, index) in filterKeys" :key="index">
                    <DropdownMenuLabel>{{
                        key.label || "Filtrer par : " + key
                    }}</DropdownMenuLabel>
                    <DropdownMenuSeparator />

                    <!-- Bind v-model to the computed ref's value -->
                    <DropdownMenuRadioGroup v-model="filters[key.key]">
                        <slot :name="key.key + 'Content'" />
                    </DropdownMenuRadioGroup>
                </template>
            </DropdownMenuContent>
        </DropdownMenu>
        <slot name="searchContent">
            <!-- Bind v-model to the computed ref's value -->
            <SearchInput
                v-model="filters.search"
                :has-filters="hasFilters"
                :loading="loading"
                @reset="resetFilters()"
            />
        </slot>
    </div>
</template>

<script setup>
import { useFilter } from "@/composables/useFilter"; // Import the composable
import SearchInput from "./SearchInput.vue"; // Assuming SearchInput is needed
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
    DropdownMenuRadioGroup,
} from "@/Components/ui/dropdown-menu";

// Define emits if they are still needed externally
const emits = defineEmits(["searched", "reseted"]); // Events are handled internally now, remove if not used externally

const props = defineProps({
    maxWidth: {
        type: Number,
        default: 300,
    },
    showFilters: {
        type: Boolean,
        default: true,
    },
    filterName: {
        type: String,
        default: null,
    },
    filterKeys: {
        type: Array,
        default: () => [],
    },
    // Pass the initial filters from page props
    dataFilters: {
        type: Object,
        default: () => ({}),
    },
});

// Instantiate the composable
// Destructure 'filters' (computed ref) instead of 'form'
const { filters, loading, hasFilters, resetFilters } = useFilter({
    filterName: props.filterName,
    filterKeys: props.filterKeys,
    // Extract initial filters for the specific filterName or use the general filters
    initialFilters: props.filterName
        ? props.dataFilters[props.filterName] || {}
        : props.dataFilters || {},
    // Pass emits as callbacks
    onSearched: (page) => emits("searched", page), // Emit 'searched' on successful filter application
    onReseted: (page) => emits("reseted", page), // Emit 'reseted' on successful filter reset
});
</script>
