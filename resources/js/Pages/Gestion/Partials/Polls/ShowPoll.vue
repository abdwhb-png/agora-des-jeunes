<template>
    <Loader v-if="loading" />
    <Card v-else-if="pollData">
        <template #title>
            {{ pollData.total_votes }} votes enregistrés au total
        </template>
        <template #content>
            <div class="flex justify-center">
                <Chart
                    type="pie"
                    :data="chartData"
                    :options="chartOptions"
                    class="w-full md:w-[30rem] flex justify-center"
                />
            </div>
        </template>
    </Card>
</template>

<script setup lang="ts">
import { generateColor } from "@/utils/helpers";
import { onMounted, ref } from "vue";

interface ResultsItem {
    option: string;
    votes: number;
}

const props = defineProps({
    id: Number,
});

const loading = ref(false);

const chartData = ref();
const chartOptions = ref();

const pollData = ref(null);

onMounted(async () => {
    loading.value = true;
    const url = route("poll.show", { id: props.id });
    await axios.get(url).then((response) => {
        pollData.value = response.data;
        chartData.value = setChartData();
        chartOptions.value = setChartOptions();
    });
    loading.value = false;
});

const parsedResults = (): Array<Array<string | number>> => {
    const labels = [];
    const data = [];
    const bgColor = [];
    const hoverBgColor = [];

    pollData.value.results?.forEach((item: ResultsItem, index: number) => {
        labels.push(item.option);
        data.push(item.votes);
        bgColor.push(generateColor(index));
        hoverBgColor.push(generateColor(index, 0.7));
    });

    return [labels, data, bgColor, hoverBgColor];
};

const setChartData = () => {
    return {
        labels: parsedResults()[0],
        datasets: [
            {
                data: parsedResults()[1],
                backgroundColor: parsedResults()[2],
                hoverBackgroundColor: parsedResults()[3],
            },
        ],
    };
};

const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue("--p-text-color");

    return {
        plugins: {
            legend: {
                labels: {
                    usePointStyle: false,
                    color: textColor,
                },
            },
        },
    };
};
</script>
