<script setup>
defineProps({
    title: {
        type: String,
        default: "Erreur",
    },
});
</script>

<template>
    <Head :title="title" />
    <div class="flex flex-col items-center justify-center grow min-h-screen">
        <slot />
    </div>
</template>
