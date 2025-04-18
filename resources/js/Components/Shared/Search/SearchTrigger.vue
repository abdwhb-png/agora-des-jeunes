<script setup lang="ts">
import GlobalSearch from "./GlobalSearch.vue";

defineProps({
    component: {
        type: String,
        default: "global",
        validate: (value: string) => {
            return ["global", "simple"].includes(value);
        },
    },
});
</script>

<template>
    <slot>
        <GlobalSearch v-if="component === 'global'">
            <template #icon>
                <i class="ki-filled ki-magnifier"> </i>
            </template>
        </GlobalSearch>
        <button
            v-else-if="component === 'simple'"
            class="btn btn-icon btn-icon-lg size-9 rounded-full hover:bg-primary-light hover:text-primary text-gray-500"
            data-modal-toggle="#search_modal"
        >
            <i class="ki-filled ki-magnifier"> </i>
        </button>
    </slot>
</template>
