<script setup lang="ts">
import { ref, onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import {
    UserStats,
    ActivityStats,
    GeographicStats,
    CareerStats,
    PollStats,
} from "@/Components/stats/types";
import UserStatsCard from "@/Components/stats/UserStatsCard.vue";
import ActivityStatsCard from "@/Components/stats/ActivityStatsCard.vue";
import GeographicStatsCard from "@/Components/stats/GeographicStatsCard.vue";
import CareerStatsCard from "@/Components/stats/CareerStatsCard.vue";
import PollStatsCard from "@/Components/stats/PollStatsCard.vue";

// State
const loading = ref(true);
const error = ref<string | null>(null);
const dateRange = ref({
    start: new Date(Date.now() - 30 * 24 * 60 * 60 * 1000)
        .toISOString()
        .split("T")[0], // Last 30 days as YYYY-MM-DD
    end: new Date().toISOString().split("T")[0], // Today as YYYY-MM-DD
});

// Stats data
const userStats = ref<UserStats>({
    loading: true,
    error: null,
});
const activityStats = ref<ActivityStats>({
    loading: true,
    error: null,
});
const geographicStats = ref<GeographicStats>({
    loading: true,
    error: null,
});
const careerStats = ref<CareerStats>({
    loading: true,
    error: null,
});
const pollStats = ref<PollStats>({
    loading: true,
    error: null,
});

// Methods
const fetchStats = async () => {
    try {
        loading.value = true;
        error.value = null;

        // Fetch stats from backend
        const response = await fetch(
            `/api/stats?start=${dateRange.value.start}&end=${dateRange.value.end}`,
        );
        if (!response.ok) throw new Error("Failed to fetch stats");

        const data = await response.json();

        // Update component data
        userStats.value = { ...data.userStats, loading: false, error: null };
        activityStats.value = {
            ...data.activityStats,
            loading: false,
            error: null,
        };
        geographicStats.value = {
            ...data.geographicStats,
            loading: false,
            error: null,
        };
        careerStats.value = {
            ...data.careerStats,
            loading: false,
            error: null,
        };
        pollStats.value = { ...data.pollStats, loading: false, error: null };
    } catch (err) {
        error.value = err instanceof Error ? err.message : "An error occurred";
        console.error("Error fetching stats:", err);
    } finally {
        loading.value = false;
    }
};

const refreshStats = () => {
    fetchStats();
};

const exportStats = () => {
    // Implementation for exporting stats
    const data = {
        userStats: userStats.value,
        activityStats: activityStats.value,
        geographicStats: geographicStats.value,
        careerStats: careerStats.value,
        pollStats: pollStats.value,
    };

    const blob = new Blob([JSON.stringify(data, null, 2)], {
        type: "application/json",
    });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = `stats-${new Date().toISOString().split("T")[0]}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
};

// Lifecycle
onMounted(() => {
    fetchStats();
});
</script>

<template>
    <MainLayout title="Statistiques">
        <Head>
            <meta
                name="description"
                content="Platform statistics and analytics dashboard"
            />
        </Head>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Statistiques de la plateforme
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Vue d'ensemble complète des métriques et indicateurs de
                        performance de la plateforme
                    </p>
                </div>

                <div class="flex space-x-4">
                    <!-- Date Range Selector -->
                    <div class="flex items-center space-x-2">
                        <input
                            type="date"
                            v-model="dateRange.start"
                            class="input"
                        />
                        <span>à</span>
                        <input
                            type="date"
                            v-model="dateRange.end"
                            class="input"
                        />
                    </div>

                    <!-- Actions -->
                    <Button
                        @click="refreshStats"
                        size="small"
                        severity="secondary"
                    >
                        Actualiser
                    </Button>

                    <Button
                        size="small"
                        severity="contrast"
                        outlined
                        @click="exportStats"
                    >
                        Exporter
                    </Button>
                </div>
            </div>

            <!-- Error Alert -->
            <div v-if="error" class="mb-8 rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-danger">
                            Erreur lors du chargement des statistiques
                        </h3>
                        <div class="mt-2 text-sm text-red-700">{{ error }}</div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Statistics -->
                <UserStatsCard v-bind="userStats" class="col-span-1" />

                <!-- Poll Statistics -->
                <PollStatsCard v-bind="pollStats" class="col-span-1" />

                <!-- Geographic Statistics -->
                <GeographicStatsCard
                    v-bind="geographicStats"
                    class="col-span-1 md:col-span-2"
                />

                <!-- Career Statistics -->
                <CareerStatsCard
                    v-bind="careerStats"
                    class="col-span-1 md:col-span-1"
                />

                <!-- Activity Statistics -->
                <ActivityStatsCard v-bind="activityStats" class="col-span-1" />
            </div>
        </div>
    </MainLayout>
</template>

<style>
.stats-item {
    @apply p-4 rounded-lg border border-secondary-100 dark:border-secondary-300;
}
</style>
