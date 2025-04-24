<script setup lang="ts">
import { computed } from "vue";
import type { ActivityStats, StatValue } from "./types";

const props = withDefaults(defineProps<ActivityStats>(), {
    loading: false,
    error: null,
    darkMode: false,
});

const formatValue = (value: number, isPercentage?: boolean): string => {
    if (isPercentage) {
        return `${value.toFixed(1)}%`;
    }
    return new Intl.NumberFormat().format(value);
};

const formatDuration = (minutes: number): string => {
    const hours = Math.floor(minutes / 60);
    const remainingMinutes = minutes % 60;
    return hours > 0
        ? `${hours}h ${remainingMinutes}m`
        : `${remainingMinutes}m`;
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

const renderStatValue = (stat?: StatValue, isDuration?: boolean) => {
    if (!stat) return null;

    return {
        displayValue: isDuration
            ? formatDuration(stat.value)
            : formatValue(
                  stat.value,
                  stat.label.toLowerCase().includes("rate"),
              ),
        label: stat.label,
        change: stat.change,
        trend: stat.trend,
        trendColor: getTrendColor(stat.trend),
    };
};
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
                <div v-if="totalActivities" class="stats-item">
                    <template v-if="renderStatValue(totalActivities)">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold">{{
                                renderStatValue(totalActivities).displayValue
                            }}</span>
                            <span class="text-sm text-gray-500">{{
                                renderStatValue(totalActivities).label
                            }}</span>
                            <div
                                v-if="
                                    renderStatValue(totalActivities).change !==
                                    undefined
                                "
                                :class="[
                                    'flex items-center mt-1',
                                    renderStatValue(totalActivities).trendColor,
                                ]"
                            >
                                <span class="text-sm">
                                    {{
                                        renderStatValue(totalActivities)
                                            .change > 0
                                            ? "+"
                                            : ""
                                    }}{{
                                        renderStatValue(totalActivities).change
                                    }}%
                                </span>
                            </div>
                        </div>
                    </template>
                </div>
                <div v-if="completionRate" class="stats-item">
                    <template v-if="renderStatValue(completionRate)">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold">{{
                                renderStatValue(completionRate).displayValue
                            }}</span>
                            <span class="text-sm text-gray-500">{{
                                renderStatValue(completionRate).label
                            }}</span>
                            <div
                                v-if="
                                    renderStatValue(completionRate).change !==
                                    undefined
                                "
                                :class="[
                                    'flex items-center mt-1',
                                    renderStatValue(completionRate).trendColor,
                                ]"
                            >
                                <span class="text-sm">
                                    {{
                                        renderStatValue(completionRate).change >
                                        0
                                            ? "+"
                                            : ""
                                    }}{{
                                        renderStatValue(completionRate).change
                                    }}%
                                </span>
                            </div>
                        </div>
                    </template>
                </div>
                <div v-if="avgDuration" class="stats-item">
                    <template v-if="renderStatValue(avgDuration, true)">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold">{{
                                renderStatValue(avgDuration, true).displayValue
                            }}</span>
                            <span class="text-sm text-gray-500">{{
                                renderStatValue(avgDuration, true).label
                            }}</span>
                            <div
                                v-if="
                                    renderStatValue(avgDuration, true)
                                        .change !== undefined
                                "
                                :class="[
                                    'flex items-center mt-1',
                                    renderStatValue(avgDuration, true)
                                        .trendColor,
                                ]"
                            >
                                <span class="text-sm">
                                    {{
                                        renderStatValue(avgDuration, true)
                                            .change > 0
                                            ? "+"
                                            : ""
                                    }}{{
                                        renderStatValue(avgDuration, true)
                                            .change
                                    }}%
                                </span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Chart Section -->
                <div v-if="chartData" class="col-span-full mt-6">
                    <div class="h-64 bg-gray-50 dark:bg-gray-900 rounded-lg">
                        <!-- Add chart component here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
