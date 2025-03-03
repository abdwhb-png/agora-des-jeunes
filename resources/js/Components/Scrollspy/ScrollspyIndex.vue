<template>
    <div
        data-scrollspy="false"
        :data-scrollspy-target="target"
        :data-scrollspy-smooth="smooth"
        :data-scrollspy-offset="offset"
        ref="scrollspyRef"
    >
        <slot>
            <ScrollspyMenu v-if="items" :items="items" />
        </slot>
    </div>
</template>

<script setup lang="ts">
import { ref, nextTick, onMounted } from "vue";
import { IScrollspyMenuItem } from "@/types";
import ScrollspyMenu from "./ScrollspyMenu.vue";

const props = defineProps({
    target: {
        type: String,
        default: "#scrollable_content",
    },
    smooth: {
        type: Boolean,
        default: true,
    },
    offset: {
        type: String,
        default: 0,
    },
    items: {
        type: Array as () => IScrollspyMenuItem[],
        required: false,
        default: null,
    },
});

const scrollspyRef = ref();

const init = () => {
    if (!scrollspyRef.value) return;

    const options = {
        target: props.target,
        offset: props.offset,
        smooth: props.smooth,
    };

    new KTScrollspy(scrollspyRef.value, options);
};

onMounted(() => {
    nextTick(() => {
        init();
        const scrollspy = KTScrollspy.getInstance(scrollspyRef.value);

        scrollspy.on("activate", (element) => {
            // console.log("anchor activate event", element);
        });
    });
});
</script>
