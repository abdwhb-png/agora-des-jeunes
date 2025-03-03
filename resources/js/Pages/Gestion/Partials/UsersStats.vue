<template>
    <div class="flex flex-col gap-0.5">
        <span class="text-sm font-normal text-gray-700">
            Utilisateurs au total
        </span>
        <div class="flex items-center gap-2.5">
            <span class="text-3xl font-semibold text-gray-900">
                {{ data.all_count }}
            </span>
            <span
                class="badge badge-outline badge-sm"
                :class="data.week_count > 0 ? 'badge-success' : ''"
            >
                {{ "+" + data.week_count }}
                cette semaine
            </span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    data: { type: Object },
});
</script>
