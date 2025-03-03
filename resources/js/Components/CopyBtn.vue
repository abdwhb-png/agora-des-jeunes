<template>
    <i
        v-if="text"
        @click="copy"
        class="cursor-pointer ki-filled"
        :class="copied ? 'ki-copy-success text-success' : 'ki-copy'"
    ></i>
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
