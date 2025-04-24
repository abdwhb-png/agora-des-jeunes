<script setup lang="ts">
import { computed } from "vue";
import type { CareerStats, StatValue } from "./types";

const props = withDefaults(defineProps<CareerStats>(), {
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

const getProgressColor = (value: number): string => {
    if (value >= 80) return "bg-green-500";
    if (value >= 60) return "bg-yellow-500";
    return "bg-blue-500";
};

const getStatDisplay = (stat: StatValue) => {
    const isPercentage = stat.label.toLowerCase().includes("rate");
    return {
        displayValue: formatValue(stat.value, isPercentage),
        isPercentage,
        progressColor: getProgressColor(stat.value),
        trendColor: getTrendColor(stat.trend),
        changePrefix: stat.change && stat.change > 0 ? "+" : "",
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
                    <div
                        class="h-2 bg-gray-200 dark:bg-gray-700 rounded w-full mt-2"
                    ></div>
                </div>
            </div>

            <!-- Content State -->
            <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div v-if="jobPlacements" class="stats-item">
                    <div class="flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-2xl font-bold">{{
                                getStatDisplay(jobPlacements).displayValue
                            }}</span>
                            <span
                                v-if="jobPlacements.change !== undefined"
                                :class="`text-sm ${getStatDisplay(jobPlacements).trendColor}`"
                            >
                                {{ getStatDisplay(jobPlacements).changePrefix
                                }}{{ jobPlacements.change }}%
                            </span>
                        </div>
                        <span class="text-sm text-gray-500">{{
                            jobPlacements.label
                        }}</span>
                        <div
                            v-if="getStatDisplay(jobPlacements).isPercentage"
                            class="mt-2 h-2 w-full bg-gray-200 rounded-full overflow-hidden"
                        >
                            <div
                                :class="`h-full ${getStatDisplay(jobPlacements).progressColor}`"
                                :style="`width: ${jobPlacements.value}%`"
                            ></div>
                        </div>
                    </div>
                </div>

                <div v-if="trainingCompleted" class="stats-item">
                    <div class="flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-2xl font-bold">{{
                                getStatDisplay(trainingCompleted).displayValue
                            }}</span>
                            <span
                                v-if="trainingCompleted.change !== undefined"
                                :class="`text-sm ${getStatDisplay(trainingCompleted).trendColor}`"
                            >
                                {{
                                    getStatDisplay(trainingCompleted)
                                        .changePrefix
                                }}{{ trainingCompleted.change }}%
                            </span>
                        </div>
                        <span class="text-sm text-gray-500">{{
                            trainingCompleted.label
                        }}</span>
                        <div
                            v-if="
                                getStatDisplay(trainingCompleted).isPercentage
                            "
                            class="mt-2 h-2 w-full bg-gray-200 rounded-full overflow-hidden"
                        >
                            <div
                                :class="`h-full ${getStatDisplay(trainingCompleted).progressColor}`"
                                :style="`width: ${trainingCompleted.value}%`"
                            ></div>
                        </div>
                    </div>
                </div>

                <div v-if="certifications" class="stats-item">
                    <div class="flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-2xl font-bold">{{
                                getStatDisplay(certifications).displayValue
                            }}</span>
                            <span
                                v-if="certifications.change !== undefined"
                                :class="`text-sm ${getStatDisplay(certifications).trendColor}`"
                            >
                                {{ getStatDisplay(certifications).changePrefix
                                }}{{ certifications.change }}%
                            </span>
                        </div>
                        <span class="text-sm text-gray-500">{{
                            certifications.label
                        }}</span>
                        <div
                            v-if="getStatDisplay(certifications).isPercentage"
                            class="mt-2 h-2 w-full bg-gray-200 rounded-full overflow-hidden"
                        >
                            <div
                                :class="`h-full ${getStatDisplay(certifications).progressColor}`"
                                :style="`width: ${certifications.value}%`"
                            ></div>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div v-if="chartData" class="col-span-full mt-6">
                    <div class="h-64 bg-gray-50 dark:bg-gray-900 rounded-lg">
                        <!-- Add chart component here -->
                        <div
                            class="flex items-center justify-center h-full text-gray-400"
                        >
                            Career Progress Chart
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
