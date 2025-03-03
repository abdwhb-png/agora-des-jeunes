<script setup>
defineProps({
    title: {
        type: String,
    },
});
</script>

<template>
    <div class="card card-grid h-full min-w-full">
        <div class="card-header">
            <h3 v-show="title" class="card-title">
                {{ title }}
            </h3>
            <slot name="header" />
        </div>

        <div v-if="$slots.default" class="card-body scrollable">
            <slot />
        </div>

        <slot name="footer">
            <div class="card-footer"></div>
        </slot>
    </div>
</template>
