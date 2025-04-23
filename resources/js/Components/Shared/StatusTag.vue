<template>
    <Tag
        v-if="!isBadge"
        :value="status.label"
        :severity="status.value ? 'info' : 'danger'"
    />
    <span
        v-else
        class="badge badge-outline rounded-[30px]"
        :class="status.value ? 'badge-primary' : 'badge-danger'"
    >
        <span
            class="size-1.5 rounded-full me-1.5"
            :class="status.value ? 'bg-primary' : 'bg-danger'"
        >
        </span>
        {{ status.label }}
    </span>
</template>

<script setup lang="ts">
import { stat } from "fs";

interface Status {
    label: string;
    value: boolean;
}

defineProps({
    status: { type: Object as () => Status, required: true },
    isBadge: { type: Boolean, default: false },
});
</script>
