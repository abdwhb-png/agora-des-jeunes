<template>
    <div class="container-fixed">
        <div
            class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5"
        >
            <div class="flex flex-col justify-center gap-2">
                <div class="flex items-center gap-2">
                    <Link href="/" class="btn btn-icon btn-sm">
                        <i class="ki-filled ki-home"></i>
                        <span class="ml-2">/</span>
                    </Link>
                    <h1 class="text-xl font-medium leading-none text-gray-900">
                        {{ title }}
                    </h1>
                </div>
                <div
                    class="flex items-center gap-2 text-sm font-normal text-gray-700"
                >
                    {{ description }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <Link
                    v-if="!route().current('profil')"
                    class="btn btn-sm btn-light"
                    :href="route('profil')"
                >
                    Mon Profil
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: String,
    description: String,
});
</script>
