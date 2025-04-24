<script setup lang="ts">
import { computed } from "vue";
import type { PollStats, StatValue } from "./types";
import StatsChart from "./StatsChart.vue";

const props = withDefaults(defineProps<PollStats>(), {
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
                <div v-if="totalPolls" class="stats-item">
                    <div class="flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-2xl font-bold">{{
                                getStatDisplay(totalPolls).displayValue
                            }}</span>
                            <span
                                v-if="totalPolls.change !== undefined"
                                :class="`text-sm ${getStatDisplay(totalPolls).trendColor}`"
                            >
                                {{ getStatDisplay(totalPolls).changePrefix
                                }}{{ totalPolls.change }}%
                            </span>
                        </div>
                        <span class="text-sm text-gray-500">{{
                            totalPolls.label
                        }}</span>
                        <div
                            v-if="getStatDisplay(totalPolls).isPercentage"
                            class="mt-2 h-2 w-full bg-gray-200 rounded-full overflow-hidden"
                        >
                            <div
                                :class="`h-full ${getStatDisplay(totalPolls).progressColor}`"
                                :style="`width: ${totalPolls.value}%`"
                            ></div>
                        </div>
                    </div>
                </div>

                <div v-if="activePolls" class="stats-item">
                    <div class="flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-2xl font-bold">{{
                                getStatDisplay(activePolls).displayValue
                            }}</span>
                            <span
                                v-if="activePolls.change !== undefined"
                                :class="`text-sm ${getStatDisplay(activePolls).trendColor}`"
                            >
                                {{ getStatDisplay(activePolls).changePrefix
                                }}{{ activePolls.change }}%
                            </span>
                        </div>
                        <span class="text-sm text-gray-500">{{
                            activePolls.label
                        }}</span>
                        <div
                            v-if="getStatDisplay(activePolls).isPercentage"
                            class="mt-2 h-2 w-full bg-gray-200 rounded-full overflow-hidden"
                        >
                            <div
                                :class="`h-full ${getStatDisplay(activePolls).progressColor}`"
                                :style="`width: ${activePolls.value}%`"
                            ></div>
                        </div>
                    </div>
                </div>

                <div v-if="totalVotes" class="stats-item">
                    <div class="flex flex-col">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-2xl font-bold">{{
                                getStatDisplay(totalVotes).displayValue
                            }}</span>
                            <span
                                v-if="totalVotes.change !== undefined"
                                :class="`text-sm ${getStatDisplay(totalVotes).trendColor}`"
                            >
                                {{ getStatDisplay(totalVotes).changePrefix
                                }}{{ totalVotes.change }}%
                            </span>
                        </div>
                        <span class="text-sm text-gray-500">{{
                            totalVotes.label
                        }}</span>
                        <div
                            v-if="getStatDisplay(totalVotes).isPercentage"
                            class="mt-2 h-2 w-full bg-gray-200 rounded-full overflow-hidden"
                        >
                            <div
                                :class="`h-full ${getStatDisplay(totalVotes).progressColor}`"
                                :style="`width: ${totalVotes.value}%`"
                            ></div>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div v-if="chartData" class="col-span-full mt-6">
                    <div class="h-64">
                        <StatsChart :data="chartData" :dark-mode="darkMode" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
