<script setup lang="ts">
import HomeBtn from "@/Components/HomeBtn.vue";
</script>

<template>
    <ErrorLayout title="403 Error">
        <div class="flex flex-col items-center">
            <div class="mb-16">
                <img
                    alt="image"
                    class="dark:hidden max-h-[160px]"
                    src="/images/non-autorise.png"
                />
                <img
                    alt="image"
                    class="light:hidden max-h-[160px]"
                    src="/images/non-autorise.png"
                />
            </div>
            <span class="badge badge-dark badge-outline mb-3">
                Erreur 403
            </span>
            <h3 class="text-2.5xl font-semibold text-gray-900 text-center mb-2">
                Non Autorisé
            </h3>
            <div class="text-md text-center text-gray-700 mb-10">
                Vous n'êtes pas autorisé à accéder à cette page.
            </div>
            <HomeBtn />
        </div>
    </ErrorLayout>
</template>
