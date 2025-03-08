<script setup>
const url = import.meta.env.VITE_FRONTEND_URL;
</script>

<template>
    <Button
        asChild
        v-slot="slotProps"
        class="btn btn-secondary btn-outline"
        severity="secondary"
        raised
        size="small"
        outlined
    >
        <Link href="/" :class="slotProps.class">
            <i class="pi pi-home"></i>
            Accueil
        </Link>
    </Button>
</template>
