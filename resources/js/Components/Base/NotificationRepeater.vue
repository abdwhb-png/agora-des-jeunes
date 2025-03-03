<script setup>
const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="flex grow gap-2.5 px-5">
        <div class="relative shrink-0 mt-0.5">
            <img
                alt=""
                class="rounded-full size-8"
                src="/static/media/avatars/300-5.png"
            />
            <span
                class="size-1.5 badge badge-circle badge-success absolute top-7 end-0.5 ring-1 ring-light transform -translate-y-1/2"
            >
            </span>
        </div>
        <div class="flex flex-col gap-3.5">
            <div class="flex flex-col gap-1">
                <div class="text-2sm font-medium mb-px">
                    <a
                        class="hover:text-primary-active text-gray-900 font-semibold"
                        href="#"
                    >
                        Leslie Alexander
                    </a>
                    <span class="text-gray-700"> added new tags to </span>
                    <a class="hover:text-primary-active text-primary" href="#">
                        Web Redesign 2024
                    </a>
                </div>
                <span
                    class="flex items-center text-2xs font-medium text-gray-500"
                >
                    53 mins ago
                    <span class="badge badge-circle bg-gray-500 size-1 mx-1.5">
                    </span>
                    ACME
                </span>
            </div>
            <div class="flex flex-wrap gap-2.5">
                <span class="badge badge-sm badge-info badge-outline">
                    Client-Request
                </span>
                <span class="badge badge-sm badge-warning badge-outline">
                    Figma
                </span>
                <span class="badge badge-sm badge-light badge-outline">
                    Redesign
                </span>
            </div>
        </div>
    </div>
</template>
