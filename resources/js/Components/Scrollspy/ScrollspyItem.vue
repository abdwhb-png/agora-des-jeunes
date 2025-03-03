<template>
    <a
        data-scrollspy-anchor="true"
        :href="item.target"
        :class="[
            'flex items-center rounded-lg pl-2.5 pr-2.5 py-2.5 border border-transparent text-gray-800 scrollspy-active:bg-secondary-active scrollspy-active:text-primary scrollspy-active:font-medium dark:hover:bg-coal-300 dark:hover:border-gray-100 hover:rounded-lg dark:scrollspy-active:bg-coal-300 dark:scrollspy-active:border-gray-100',
            {
                'gap-3.5': true,
                'gap-1.5': false,
            },
            'text-2sm hover:text-primary',
        ]"
        :scrollspy-active="item.active"
    >
        <span
            class="flex w-1.5 relative before:absolute start-px rtl:-start-[5px] before:top-0 before:size-1.5 before:rounded-full before:-translate-x-2/4 before:-translate-y-2/4 scrollspy-active:before:bg-primary"
        ></span>
        {{ item.title }}
    </a>
</template>

<script setup lang="ts">
import { IScrollspyMenuItem } from "@/types";

defineProps({
    item: {
        type: Object as () => IScrollspyMenuItem,
        required: true,
    },
});
</script>
