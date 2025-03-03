<template>
    <div
        v-if="data"
        class="card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg"
    >
        <div class="card-body pb-0">
            <div class="flex flex-col gap-2">
                <h2 class="text-1.5xl font-semibold text-gray-900">
                    Quartiers enregistrés:
                    <span class="link">{{ data.count }}</span>
                </h2>
                <p class="text-sm font-normal text-gray-700 leading-5.5">
                    Les quartiers les plus populaires
                </p>
            </div>
        </div>
        <div class="card-footer justify-center">
            <div class="md:flex items-center gap-[3rem]">
                <!--begin::Chart-->
                <div class="flex justify-center pt-2 mb-3 md:mb-0">
                    <div
                        id="kt_card_widget_17_chart"
                        :style="{
                            minWidth: `${chartSize}px`,
                            minHeight: `${chartSize}px`,
                        }"
                        :data-kt-size="chartSize"
                        :data-kt-line="11"
                    ></div>
                </div>
                <!--end::Chart-->

                <!--begin::Labels-->
                <div class="flex flex-col justify-center flex-row-fluid">
                    <template
                        v-for="(item, index) in data.top"
                        :key="item.quartier"
                    >
                        <!--begin::Label-->
                        <div
                            class="flex fw-semibold justify-between items-center"
                        >
                            <!--begin::Bullet-->
                            <div
                                class="bullet w-8px h-3px rounded-2 me-3"
                                :style="{
                                    'background-color': neighbourColor(index),
                                }"
                            ></div>
                            <!--end::Bullet-->

                            <!--begin::Label-->
                            <div
                                class="text-gray-500 flex-grow-1 me-4 capitalize"
                            >
                                {{ item.quartier }}
                            </div>
                            <!--end::Label-->

                            <!--begin::Stats-->
                            <div
                                class="fw-bolder text-gray-700 text-xxl-end text-sm"
                            >
                                {{ item.pourcentage }}%
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Label-->
                    </template>
                </div>
                <!--end::Labels-->
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { neighbourColor } from "@/utils/helpers";

const props = defineProps({
    data: { type: Object, default: null },
});

const chartSize = 70;

const initChart = async () => {
    var el = document.getElementById("kt_card_widget_17_chart");

    if (!el) {
        return;
    }

    try {
        const data = props.data.top;

        if (!data || data.length === 0) {
            console.error("Aucune donnée disponible pour le graphique.");
            return;
        }

        var options = {
            size: el.getAttribute("data-kt-size")
                ? parseInt(el.getAttribute("data-kt-size") as string)
                : 100,
            lineWidth: el.getAttribute("data-kt-line")
                ? parseInt(el.getAttribute("data-kt-line") as string)
                : 11,
            rotate: el.getAttribute("data-kt-rotate")
                ? parseInt(el.getAttribute("data-kt-rotate") as string)
                : 145,
        };

        var canvas = document.createElement("canvas");
        var span = document.createElement("span");
        var ctx = canvas.getContext("2d") as CanvasRenderingContext2D;
        canvas.width = canvas.height = options.size;

        el.appendChild(span);
        el.appendChild(canvas);

        ctx.translate(options.size / 2, options.size / 2); // Centre du canevas
        ctx.rotate(-Math.PI / 2); // Rotation pour commencer en haut

        var radius = (options.size - options.lineWidth) / 2;

        var drawArc = (color: string, start: number, end: number) => {
            ctx.beginPath();
            ctx.arc(0, 0, radius, start, end);
            ctx.strokeStyle = color;
            // ctx.lineCap = "round";
            ctx.lineWidth = options.lineWidth;
            ctx.stroke();
        };

        // Dessiner le fond gris clair
        drawArc("#E4E6EF", 0, Math.PI * 2);

        // Dessiner les quartiers en fonction des pourcentages
        let startAngle = 0;
        data.forEach((quartier: any, index: number) => {
            let percentage = quartier.pourcentage / 100;
            let endAngle = startAngle + percentage * Math.PI * 2; // Convertir en radians
            drawArc(neighbourColor(index), startAngle, endAngle);
            startAngle = endAngle; // Le prochain quartier commence à la fin du précédent
        });
    } catch (error) {
        console.error("Erreur lors de la récupération des données : ", error);
    }
};

onMounted(() => {
    initChart();
});
</script>
