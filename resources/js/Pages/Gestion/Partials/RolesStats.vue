<script setup>
const props = defineProps({
    data: { type: Object },
});

const itemColor = (index) => {
    switch (index) {
        case 0:
            return "#FFC107";
        case 1:
            return "#E91E63";
        case 2:
            return "#9C27B0";
        case 3:
            return "#673AB7";
        case 4:
            return "#3F51B5";
        case 5:
            return "#2196F3";
        case 6:
            return "#03A9F4";
        case 7:
            return "#00BCD4";
        case 8:
            return "#009688";
        default:
            return "gray";
    }
};
</script>

<template>
    <div v-if="data.length">
        <div class="flex items-center gap-1 mb-1.5">
            <div
                v-for="(item, index) in data"
                :key="item.role"
                :style="`background-color:  ${itemColor(index)}; width: ${item.percentage}%`"
                class="h-2 w-full rounded-sm"
            ></div>
        </div>
        <div class="flex items-center flex-wrap gap-4 mb-1">
            <div
                v-for="(item, index) in data"
                :key="item.role"
                class="flex items-center gap-1.5"
            >
                <i
                    :style="`color: ${item.count ? itemColor(index) : 'gray'}`"
                    class="ki-filled ki-focus"
                ></i>
                <span class="text-sm font-normal text-gray-800 capitalize">
                    {{ `${item.role} (${item.count})` }}
                </span>
            </div>
        </div>
    </div>
</template>
