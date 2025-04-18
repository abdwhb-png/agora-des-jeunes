<!-- components/OptimizedPublicImage.vue -->
<template>
    <picture>
        <!-- WebP version -->
        <source :srcset="webpPath" type="image/webp">
        <!-- Original version -->
        <v-lazy-image v-if="lazy" v-bind="$attrs" :src="originalPath" :alt="alt" @load="handleLoad"
            @error="handleError" />
        <img v-else v-bind="$attrs" :src="originalPath" :alt="alt" @load="handleLoad" @error="handleError">
    </picture>
</template>

<script setup>
import { computed } from 'vue';

defineOptions({
    inheritAttrs: false
})

// Props definition
const props = defineProps({
    path: {
        type: String,
        required: true
    },
    alt: {
        type: String,
        default: ''
    },
    lazy: {
        type: Boolean,
        default: true
    }
});

// Emits definition
const emit = defineEmits(['load', 'error']);

// Methods
const getOptimizedPath = (path, format) => {
    // Vérifier si le chemin commence déjà par un slash
    const cleanPath = path.startsWith('/') ? path.slice(1) : path;
    const parts = cleanPath.split('.');
    parts.pop(); // Enlever l'extension
    return `/${parts.join('.')}.${format}`;
};

const handleLoad = () => {
    emit('load');
};

const handleError = (error) => {
    console.error('Erreur de chargement image:', error);
    emit('error', error);
};

// Computed properties
const originalPath = computed(() => {
    return props.path.startsWith('/') ? props.path : `/${props.path}`;
});

const webpPath = computed(() => {
    return getOptimizedPath(props.path, 'webp');
});
</script>