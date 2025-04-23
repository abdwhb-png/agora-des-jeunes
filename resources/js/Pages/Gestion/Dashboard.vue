<script setup>
import DashMegaMenu from "./Partials/DashMegaMenu.vue";
import NeighboursWidget from "./Partials/NeighboursWidget.vue";
import MembersWidget from "./Partials/MembersWidget.vue";
import DashSide from "./Partials/DashSide.vue";
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
    <MainLayout title="Tableau de bord">
        <div class="grid gap-5 xl:gap-7.5">
            <!-- Dash MegaMenu -->
            <DashMegaMenu />
            <!-- End of Dash MegaMenu -->
            <div class="grid xl:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
                <div class="xl:col-span-2">
                    <div
                        class="grid md:grid-cols-4 gap-y-5 md:gap-7.5 items-stretch"
                    >
                        <div class="md:col-span-2">
                            <MembersWidget :data="$page.props.users_stats" />
                        </div>
                        <div class="md:col-span-3">
                            <NeighboursWidget
                                :data="$page.props.neighbours_stats"
                            />
                        </div>
                    </div>
                </div>
                <div class="xl:col-span-1">
                    <DashSide />
                </div>
            </div>
        </div>
    </MainLayout>
</template>
