<script setup lang="ts">
import { computed } from "vue";
import type { UserStats, StatValue } from "./types";
import StatsChart from "./StatsChart.vue";

const props = withDefaults(defineProps<UserStats>(), {
    loading: false,
    error: null,
    darkMode: false,
});

const formatValue = (value: number): string => {
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

// Removed JSX render function as it's now handled in template
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
                <div v-for="i in 3" :key="i" class="animate-pulse">
                    <div
                        class="h-8 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mb-2"
                    ></div>
                    <div
                        class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-1/2"
                    ></div>
                </div>
            </div>

            <!-- Content State -->
            <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div v-if="totalUsers" class="stats-item">
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold">{{
                            formatValue(totalUsers.value)
                        }}</span>
                        <span class="text-sm text-gray-500">{{
                            totalUsers.label
                        }}</span>
                        <div
                            v-if="totalUsers.change !== undefined"
                            :class="[
                                'flex items-center mt-1',
                                getTrendColor(totalUsers.trend),
                            ]"
                        >
                            <span class="text-sm">
                                {{ totalUsers.change > 0 ? "+" : ""
                                }}{{ totalUsers.change }}%
                            </span>
                        </div>
                    </div>
                </div>
                <div v-if="activeUsers" class="stats-item">
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold">{{
                            formatValue(activeUsers.value)
                        }}</span>
                        <span class="text-sm text-gray-500">{{
                            activeUsers.label
                        }}</span>
                        <div
                            v-if="activeUsers.change !== undefined"
                            :class="[
                                'flex items-center mt-1',
                                getTrendColor(activeUsers.trend),
                            ]"
                        >
                            <span class="text-sm">
                                {{ activeUsers.change > 0 ? "+" : ""
                                }}{{ activeUsers.change }}%
                            </span>
                        </div>
                    </div>
                </div>
                <div v-if="newUsers" class="stats-item">
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold">{{
                            formatValue(newUsers.value)
                        }}</span>
                        <span class="text-sm text-gray-500">{{
                            newUsers.label
                        }}</span>
                        <div
                            v-if="newUsers.change !== undefined"
                            :class="[
                                'flex items-center mt-1',
                                getTrendColor(newUsers.trend),
                            ]"
                        >
                            <span class="text-sm">
                                {{ newUsers.change > 0 ? "+" : ""
                                }}{{ newUsers.change }}%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div v-if="chartData" class="col-span-full mt-6">
                    <div
                        class="h-64 bg-gray-50 dark:bg-gray-900 rounded-lg p-4"
                    >
                        <StatsChart :data="chartData" :dark-mode="darkMode" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
