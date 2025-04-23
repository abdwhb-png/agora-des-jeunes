<template>
    <div class="flex gap-2 max-w-[900px] md:min-w-80">
        <div class="input input-sm max-w-56">
            <i class="ki-filled ki-magnifier"> </i>
            <input
                :value="modelValue"
                type="text"
                :placeholder="placeholder"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </div>
        <div
            v-if="modelValue"
            @click="emits('reset')"
            class="icon relative right-8 top-1"
        >
            <i
                class="ki-filled ki-cross text-gray-600 hover:text-gray-800 cursor-pointer"
            ></i>
        </div>
    </div>
</template>

<script setup>
const emits = defineEmits(["update:modelValue", "reset"]);

defineProps({
    modelValue: String,
    placeholder: {
        type: String,
        default: "Rechercher",
    },
});
</script>
