<template>
    <v-lazy-image :src="logo" :alt="alt" />
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useDarkModeStore } from '@/stores/darkMode';

const props = defineProps({
    className: String,
    favicon: {
        type: Boolean,
        default: false,
    },
});

const alt = 'Logo ' + usePage().props.app.name;
const darkModeStore = useDarkModeStore();

const logo = computed(() => {
    return props.favicon ? '/images/favicon.png' : (darkModeStore.isDark ? '/images/logo-dark.png' : '/images/logo.png');
});
</script>
