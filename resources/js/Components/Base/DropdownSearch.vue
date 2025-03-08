<template>
    <div class="dropdown" data-dropdown="true" data-dropdown-trigger="click">
        <UiButton variant="outline" size="icon" class="dropdown-toggle">
            <svg
                width="20"
                height="20"
                viewBox="0 0 20 20"
                aria-hidden="true"
                class="DocSearch-Search-Icon"
            >
                <path
                    d="M14.386 14.386l4.0877 4.0877-4.0877-4.0877c-2.9418 2.9419-7.7115 2.9419-10.6533 0-2.9419-2.9418-2.9419-7.7115 0-10.6533 2.9418-2.9419 7.7115-2.9419 10.6533 0 2.9419 2.9418 2.9419 7.7115 0 10.6533z"
                    stroke="currentColor"
                    fill="none"
                    fill-rule="evenodd"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                ></path>
            </svg>
        </UiButton>
        <div class="dropdown-content w-full md:max-w-xl p-4">
            <div class="input">
                <i class="ki-outline ki-magnifier"> </i>
                <input
                    placeholder="Rechercher..."
                    type="text"
                    :value="modelValue"
                    @input="$emit('update:modelValue', $event.target.value)"
                />
                <button
                    type="reset"
                    data-dropdown-dismiss="true"
                    class="btn btn-icon"
                    @click="$emit('reset')"
                >
                    <svg width="20" height="20" viewBox="0 0 20 20">
                        <path
                            d="M10 10l5.09-5.09L10 10l5.09 5.09L10 10zm0 0L4.91 4.91 10 10l-5.09 5.09L10 10z"
                            stroke="currentColor"
                            fill="none"
                            fill-rule="evenodd"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        ></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
defineEmits(["update:modelValue", "reset"]);

defineProps({
    modelValue: String,
});
</script>
