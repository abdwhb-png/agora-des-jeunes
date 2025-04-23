<template>
    <div class="flex flex-col gap-0.5">
        <div class="flex gap-2 max-w-[900px] md:min-w-80">
            <div class="input input-sm">
                <i class="ki-filled ki-magnifier"> </i>
                <input
                    :value="modelValue"
                    type="text"
                    @input="$emit('update:modelValue', $event.target.value)"
                    aria-label="Search"
                    autocomplete="off"
                    :placeholder="placeholder"
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
        <ProgressBar v-if="loading" mode="indeterminate" style="height: 5px" />
    </div>
</template>

<script setup>
const emits = defineEmits(["update:modelValue", "reset"]);

const props = defineProps({
    modelValue: String,
    hasFilters: Boolean,
    loading: Boolean,
    placeholder: { type: String, default: "Recherche..." },
});
</script>
