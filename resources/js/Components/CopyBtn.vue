<template>
    <div class="flex items-center gap-1" @click="copy">
        <i
            v-if="text"
            class="cursor-pointer ki-filled"
            :class="copied ? 'ki-copy-success text-primary' : 'ki-copy'"
        ></i>
        <slot></slot>
    </div>
</template>

<script setup>
import { ref } from "vue";

const emits = defineEmits(["copied"]);

const props = defineProps({
    text: {
        type: String,
        default: null,
    },
});

const copied = ref(false);

const copy = () => {
    navigator.clipboard.writeText(props.text);
    copied.value = true;
    emits("copied");
    setTimeout(() => (copied.value = false), 2000);
};
</script>
