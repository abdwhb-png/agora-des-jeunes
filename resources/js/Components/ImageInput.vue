<template>
    <div>
        <InputText
            v-bind="$attrs"
            class="cursor-pointer"
            :defaultValue="image?.name || imageName"
            @click="file.click()"
            fluid
            readonly
        />
        <input
            type="file"
            ref="file"
            @input="onInput"
            accept="image/*"
            class="hidden"
        />
    </div>
</template>

<script setup>
import { ref } from "vue";

defineOptions({
    inheritAttrs: false,
});

const emits = defineEmits(["selected"]);

defineProps({
    imageName: String,
});

const file = ref();
const image = ref(null);

const onInput = () => {
    image.value = file.value.files[0];

    emits("selected", image.value);
};
</script>
