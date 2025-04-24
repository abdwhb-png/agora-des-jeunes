<script setup>
import { ref } from "vue";

const props = defineProps({
    data: { type: Object, default: null },
});
</script>
<template>
    <div
        class="card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg"
    >
        <div class="card-body" v-if="data">
            <div class="flex flex-col justify-center gap-4">
                <h2
                    v-for="(item, index) in data"
                    :key="index"
                    class="text-1.5xl font-semibold text-gray-900"
                >
                    {{ item.label }}:
                    <span class="link">{{ item.value }}</span>
                </h2>
            </div>
        </div>
        <div class="card-footer justify-center"></div>
    </div>
</template>
