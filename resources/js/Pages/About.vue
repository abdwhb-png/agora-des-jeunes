<script setup lang="ts">
import Discover from "@/Components/Home/About/Discover.vue";
import Story from "@/Components/Home/About/Story.vue";
import Values from "@/Components/Home/About/Values.vue";
import AboutHeader from "@/Components/Home/About/AboutHeader.vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";
</script>

<template>
    <HomeLayout title="A propos" :meta="$page.props.meta">
        <template #header>
            <AboutHeader />
        </template>

        <Story />
        <Discover id="more-about" />
        <Values />
    </HomeLayout>
</template>
