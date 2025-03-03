<template>
    <v-lazy-image
        src="/images/logo.png"
        :alt="'Logo ' + $page.props.app.name"
    />
</template>

<script setup>
defineProps({
    className: String,
});
</script>
