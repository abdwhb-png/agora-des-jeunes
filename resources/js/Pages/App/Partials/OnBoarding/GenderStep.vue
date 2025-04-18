<script setup lang="ts">
import { ref } from 'vue';
import MaleAvatar from '@/Components/Shared/Icons/MaleAvatar.vue';
import FemaleAvatar from '@/Components/Shared/Icons/FemaleAvatar.vue';

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
    (e: 'next'): void;
}>();

const props = defineProps<{
    modelValue: string;
}>();

const male = 'homme';
const female = 'femme';

const selectGender = (gender: string) => {
    emit('update:modelValue', gender);
    emit('next');
};
</script>

<template>
    <div class="flex flex-col items-center w-full max-w-md mx-auto p-6">
        <h2 class="text-2xl font-bold mb-8 text-gray-800">Quel est ton genre ?</h2>

        <div class="grid grid-cols-1 gap-6 w-full">
            <button @click="selectGender(male)"
                class="flex flex-col items-center p-6 rounded-2xl border-2 transition-all duration-300" :class="[
                    modelValue === male
                        ? 'border-secondary-500 bg-secondary-50'
                        : 'border-gray-200 hover:border-secondary-300'
                ]">
                <div class="w-24 h-24 mb-4">
                    <!-- <MaleAvatar class="w-full h-full object-cover" /> -->
                    <img src="/images/avatars/male-3d.png" alt="Avatar Homme" class="w-full h-full object-cover" />
                </div>
                <span class="text-lg font-medium capitalize" :class="[
                    modelValue === male ? 'text-secondary-600' : 'text-gray-700'
                ]">{{ male }}</span>
            </button>

            <button @click="selectGender(female)"
                class="flex flex-col items-center p-6 rounded-2xl border-2 transition-all duration-300" :class="[
                    modelValue === female
                        ? 'border-secondary-500 bg-secondary-50'
                        : 'border-gray-200 hover:border-secondary-300'
                ]">
                <div class="w-24 h-24 mb-4">
                    <!-- <FemaleAvatar class="w-full h-full object-cover" /> -->
                    <img src="/images/avatars/female-3d.png" alt="Avatar Femme" class="w-full h-full object-cover" />
                </div>
                <span class="text-lg font-medium capitalize" :class="[
                    modelValue === female ? 'text-secondary-600' : 'text-gray-700'
                ]">{{ female }}</span>
            </button>
        </div>
    </div>
</template>