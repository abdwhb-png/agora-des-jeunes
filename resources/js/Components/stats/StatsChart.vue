<script setup lang="ts">
import { onMounted, ref, watch } from "vue";
import type { ChartData } from "./types";
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

interface Props {
    data: ChartData;
    darkMode?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    darkMode: false,
});

const chartRef = ref<HTMLCanvasElement | null>(null);
const chartInstance = ref<Chart | null>(null);

const createChart = () => {
    if (!chartRef.value) return;

    const ctx = chartRef.value.getContext("2d");
    if (!ctx) return;

    // Destroy existing chart if it exists
    if (chartInstance.value) {
        chartInstance.value.destroy();
    }

    const textColor = props.darkMode ? "#9CA3AF" : "#6B7280";
    const gridColor = props.darkMode
        ? "rgba(255, 255, 255, 0.1)"
        : "rgba(0, 0, 0, 0.1)";

    chartInstance.value = new Chart(ctx, {
        type: "line",
        data: {
            labels: props.data.labels,
            datasets: props.data.datasets.map((dataset) => ({
                ...dataset,
                borderColor: dataset.borderColor || "#3B82F6",
                backgroundColor:
                    dataset.backgroundColor || "rgba(59, 130, 246, 0.1)",
                borderWidth: dataset.borderWidth || 2,
                tension: 0.4,
                fill: true,
            })),
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: props.data.datasets.length > 1,
                    position: "top",
                    labels: {
                        color: textColor,
                        usePointStyle: true,
                        pointStyle: "circle",
                    },
                },
                tooltip: {
                    mode: "index",
                    intersect: false,
                    backgroundColor: props.darkMode ? "#374151" : "#FFFFFF",
                    titleColor: props.darkMode ? "#FFFFFF" : "#111827",
                    bodyColor: props.darkMode ? "#FFFFFF" : "#111827",
                    borderColor: props.darkMode ? "#4B5563" : "#E5E7EB",
                    borderWidth: 1,
                },
            },
            scales: {
                x: {
                    grid: {
                        color: gridColor,
                        drawBorder: false,
                    },
                    ticks: {
                        color: textColor,
                    },
                },
                y: {
                    grid: {
                        color: gridColor,
                        drawBorder: false,
                    },
                    ticks: {
                        color: textColor,
                        callback: (value) => {
                            return typeof value === "number"
                                ? new Intl.NumberFormat().format(value)
                                : value;
                        },
                    },
                    beginAtZero: true,
                },
            },
            interaction: {
                intersect: false,
                mode: "index",
            },
        },
    });
};

onMounted(() => {
    createChart();
});

watch(
    () => [props.data, props.darkMode],
    () => {
        createChart();
    },
    { deep: true },
);
</script>

<template>
    <div class="w-full h-full">
        <canvas ref="chartRef"></canvas>
    </div>
</template>
