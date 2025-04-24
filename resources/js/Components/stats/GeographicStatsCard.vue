<script setup lang="ts">
import { computed, ref } from "vue";
import type {
    GeographicStats,
    StatValue,
    PaginationState,
    ChartData,
} from "./types";
import StatsChart from "./StatsChart.vue";

const props = withDefaults(defineProps<GeographicStats>(), {
    loading: false,
    error: null,
    darkMode: false,
    quartiersPagination: () => ({
        currentPage: 1,
        itemsPerPage: 5,
        totalItems: 0,
    }),
    citiesPagination: () => ({
        currentPage: 1,
        itemsPerPage: 5,
        totalItems: 0,
    }),
});

const quartiersPage = ref(1);
const citiesPage = ref(1);
const itemsPerPage = 5;

const paginatedQuartiers = computed(() => {
    if (!props.quartiers) return [];
    const start = (quartiersPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.quartiers.slice(start, end);
});

const paginatedCities = computed(() => {
    if (!props.cities) return [];
    const start = (citiesPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.cities.slice(start, end);
});

const totalQuartiersPages = computed(() => {
    return props.quartiers
        ? Math.ceil(props.quartiers.length / itemsPerPage)
        : 0;
});

const totalCitiesPages = computed(() => {
    return props.cities ? Math.ceil(props.cities.length / itemsPerPage) : 0;
});

const updatePage = (section: "quartiers" | "cities", page: number) => {
    if (section === "quartiers") {
        quartiersPage.value = page;
    } else {
        citiesPage.value = page;
    }
};

const formatValue = (value: number, isPercentage?: boolean): string => {
    if (isPercentage) {
        return `${value.toFixed(1)}%`;
    }
    return new Intl.NumberFormat().format(value);
};

const getTrendColor = (trend?: "up" | "down" | "neutral"): string => {
    switch (trend) {
        case "up":
            return "text-green-500";
        case "down":
            return "text-red-500";
        default:
            return "text-gray-500";
    }
};
// Chart data preparation
const quartiersChartData = computed<ChartData | undefined>(() => {
    return props.chartDatas.quartiers || undefined;
});

const citiesChartData = computed<ChartData | undefined>(() => {
    return props.chartDatas.cities || undefined;
});

const arrondissementsChartData = computed<ChartData | undefined>(() => {
    return props.chartDatas.arrondissements || undefined;
});
</script>

<template>
    <div class="card shadow-lg rounded-lg">
        <div :class="'card-body'">
            <!-- Error State -->
            <div v-if="error" class="text-red-500 p-4 text-center">
                {{ error }}
            </div>

            <!-- Loading State -->
            <div v-else-if="loading" class="space-y-4">
                <div v-for="i in 5" :key="i" class="animate-pulse">
                    <div
                        class="h-6 bg-gray-200 dark:bg-gray-700 rounded w-full mb-2"
                    ></div>
                </div>
            </div>

            <!-- Content State -->
            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Quartiers Section -->
                <div v-if="quartiers?.length" class="stats-section">
                    <h3
                        class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300"
                    >
                        Quartiers
                    </h3>
                    <div class="space-y-2">
                        <div
                            v-for="(stat, index) in paginatedQuartiers"
                            :key="index"
                            class="flex justify-between items-center py-2 border-b last:border-0 dark:border-gray-700"
                        >
                            <span
                                class="text-sm text-gray-600 dark:text-gray-300"
                            >
                                {{ stat.label }}
                            </span>
                            <div class="flex items-center">
                                <span class="font-semibold">
                                    {{
                                        formatValue(
                                            stat.value,
                                            stat.label.includes("%"),
                                        )
                                    }}
                                </span>
                                <span
                                    v-if="stat.change !== undefined"
                                    :class="[
                                        'ml-2',
                                        'text-xs',
                                        getTrendColor(stat.trend),
                                    ]"
                                >
                                    {{ stat.change > 0 ? "+" : ""
                                    }}{{ stat.change }}%
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Quartiers Pagination -->
                    <div
                        v-if="totalQuartiersPages > 1"
                        class="flex justify-center items-center mt-4 space-x-2"
                    >
                        <button
                            @click="updatePage('quartiers', quartiersPage - 1)"
                            :disabled="quartiersPage === 1"
                            class="px-3 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 disabled:opacity-50"
                            :class="{
                                'hover:bg-gray-200 dark:hover:bg-gray-600':
                                    quartiersPage !== 1,
                            }"
                        >
                            Précédent
                        </button>
                        <span class="text-sm text-gray-600 dark:text-gray-300">
                            {{ quartiersPage }} / {{ totalQuartiersPages }}
                        </span>
                        <button
                            @click="updatePage('quartiers', quartiersPage + 1)"
                            :disabled="quartiersPage === totalQuartiersPages"
                            class="px-3 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 disabled:opacity-50"
                            :class="{
                                'hover:bg-gray-200 dark:hover:bg-gray-600':
                                    quartiersPage !== totalQuartiersPages,
                            }"
                        >
                            Suivant
                        </button>
                    </div>
                </div>

                <!-- Cities Section -->
                <div v-if="cities?.length" class="stats-section">
                    <h3
                        class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300"
                    >
                        Villes
                    </h3>
                    <div class="space-y-2">
                        <div
                            v-for="(stat, index) in paginatedCities"
                            :key="index"
                            class="flex justify-between items-center py-2 border-b last:border-0 dark:border-gray-700"
                        >
                            <span
                                class="text-sm text-gray-600 dark:text-gray-300"
                            >
                                {{ stat.label }}
                            </span>
                            <div class="flex items-center">
                                <span class="font-semibold">
                                    {{
                                        formatValue(
                                            stat.value,
                                            stat.label.includes("%"),
                                        )
                                    }}
                                </span>
                                <span
                                    v-if="stat.change !== undefined"
                                    :class="[
                                        'ml-2',
                                        'text-xs',
                                        getTrendColor(stat.trend),
                                    ]"
                                >
                                    {{ stat.change > 0 ? "+" : ""
                                    }}{{ stat.change }}%
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Cities Pagination -->
                    <div
                        v-if="totalCitiesPages > 1"
                        class="flex justify-center items-center mt-4 space-x-2"
                    >
                        <button
                            @click="updatePage('cities', citiesPage - 1)"
                            :disabled="citiesPage === 1"
                            class="px-3 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 disabled:opacity-50"
                            :class="{
                                'hover:bg-gray-200 dark:hover:bg-gray-600':
                                    citiesPage !== 1,
                            }"
                        >
                            Précédent
                        </button>
                        <span class="text-sm text-gray-600 dark:text-gray-300">
                            {{ citiesPage }} / {{ totalCitiesPages }}
                        </span>
                        <button
                            @click="updatePage('cities', citiesPage + 1)"
                            :disabled="citiesPage === totalCitiesPages"
                            class="px-3 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 disabled:opacity-50"
                            :class="{
                                'hover:bg-gray-200 dark:hover:bg-gray-600':
                                    citiesPage !== totalCitiesPages,
                            }"
                        >
                            Suivant
                        </button>
                    </div>
                </div>

                <!-- Chart Sections -->
                <div class="col-span-full my-6 space-y-10">
                    <!-- Quartiers Chart -->
                    <div v-if="quartiersChartData" class="h-64">
                        <h3
                            class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300"
                        >
                            Distribution par quartier
                        </h3>
                        <StatsChart
                            :data="quartiersChartData"
                            :dark-mode="darkMode"
                        />
                    </div>

                    <!-- Cities Chart -->
                    <div v-if="citiesChartData" class="h-64">
                        <h3
                            class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300"
                        >
                            Distribution par ville
                        </h3>
                        <StatsChart
                            :data="citiesChartData"
                            :dark-mode="darkMode"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.stats-section {
    @apply p-4 rounded-lg border border-gray-200 dark:border-gray-700;
}
</style>
