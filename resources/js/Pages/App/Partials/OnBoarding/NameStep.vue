<script setup lang="ts">
import { ref, computed } from 'vue';

const emit = defineEmits<{
    (e: 'update:firstName', value: string): void;
    (e: 'update:lastName', value: string): void;
    (e: 'next'): void;
}>();

const props = defineProps<{
    firstName: string;
    lastName: string;
}>();

const form = ref({
    firstName: props.firstName,
    lastName: props.lastName
});

const isValid = computed(() => {
    return form.value.firstName.length >= 2 && form.value.lastName.length >= 2;
});

const handleSubmit = () => {
    if (!isValid.value) return;

    emit('update:firstName', form.value.firstName);
    emit('update:lastName', form.value.lastName);
    emit('next');
};
</script>

<template>
    <div class="flex flex-col items-center w-full max-w-md mx-auto p-6">
        <h2 class="text-2xl font-bold mb-8 text-gray-800">Comment t'appelles-tu ?</h2>

        <form @submit.prevent="handleSubmit" class="w-full space-y-6">
            <div class="space-y-4">
                <div>
                    <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                    <input id="firstName" v-model="form.firstName" type="text"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-secondary-500 focus:ring-secondary-500 transition-colors duration-300"
                        :class="{ 'border-secondary-500 bg-secondary-50': form.firstName }"
                        placeholder="Votre prénom" />
                </div>

                <div>
                    <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input id="lastName" v-model="form.lastName" type="text"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-secondary-500 focus:ring-secondary-500 transition-colors duration-300"
                        :class="{ 'border-secondary-500 bg-secondary-50': form.lastName }" placeholder="Votre nom" />
                </div>
            </div>

            <button type="submit"
                class="w-full py-3 px-4 rounded-xl text-white font-medium transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                :class="[
                    isValid
                        ? 'bg-gradient-to-r from-secondary-500 to-secondary-600 hover:from-secondary-600 hover:to-secondary-700'
                        : 'bg-gray-300'
                ]" :disabled="!isValid">
                Continuer
            </button>
        </form>
    </div>
</template>