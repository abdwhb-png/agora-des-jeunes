<script setup lang="ts">
import Discover from "@/Components/Home/About/Discover.vue";
import Story from "@/Components/Home/About/Story.vue";
import Values from "@/Components/Home/About/Values.vue";
import AboutHeader from "@/Components/Home/AboutHeader.vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";
</script>

<template>
    <HomeLayout title="A propos">
        <template #header>
            <AboutHeader />
        </template>

        <Story />
        <Discover />
        <Values />
    </HomeLayout>
</template>
