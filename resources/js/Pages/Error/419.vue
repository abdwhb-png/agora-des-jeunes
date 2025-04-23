<script setup lang="ts">
import HomeBtn from "@/Components/HomeBtn.vue";
</script>

<template>
    <ErrorLayout>
        <div class="flex flex-col items-center">
            <div class="mb-16">
                <img
                    alt="image"
                    class="dark:hidden max-h-[160px]"
                    src="/static/media/illustrations/expired.png"
                />
                <img
                    alt="image"
                    class="light:hidden max-h-[160px]"
                    src="/static/media/illustrations/expired.png"
                />
            </div>
            <span class="badge badge-info badge-outline mb-3">
                Erreur 419
            </span>
            <h3 class="text-2.5xl font-semibold text-gray-900 text-center mb-2">
                Page Expirée
            </h3>
            <div class="text-md text-center text-gray-700 mb-10">
                La page actuelle est expirée. Veuillez
                <a class="link font-medium" href="#" onclick="refreshPage()">
                    réactualiser la page </a
                >.
            </div>
            <HomeBtn />
        </div>
    </ErrorLayout>
</template>
