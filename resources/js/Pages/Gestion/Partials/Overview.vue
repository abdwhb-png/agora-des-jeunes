<script setup lang="ts">
import NeighboursWidget from "./NeighboursWidget.vue";
import MembersWidget from "./MembersWidget.vue";
</script>

<style>
.channel-stats-bg {
    background-image: url("/static/media/images/2600x1600/bg-3.png");
}
.dark .channel-stats-bg {
    background-image: url("/static/media/images/2600x1600/bg-3-dark.png");
}
</style>

<template>
    <div class="grid md:grid-cols-4 gap-y-5 md:gap-7.5 items-stretch">
        <div class="md:col-span-2">
            <MembersWidget :data="$page.props.users_stats" />
        </div>
        <div class="md:col-span-3">
            <NeighboursWidget :data="$page.props.neighbours_stats" />
        </div>
    </div>
</template>
