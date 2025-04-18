<script setup lang="ts">
import { ref } from 'vue';

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
    (e: 'next'): void;
}>();

const props = defineProps<{
    modelValue: string;
}>();

const occupations = [
    {
        id: 'student',
        label: 'Étudiant',
        icon: '🎓',
        description: 'En cours d\'études'
    },
    {
        id: 'worker',
        label: 'Travailleur',
        icon: '💼',
        description: 'En activité professionnelle'
    },
    {
        id: 'entrepreneur',
        label: 'Entrepreneur',
        icon: '🚀',
        description: 'Chef d\'entreprise ou indépendant'
    },
    {
        id: 'jobseeker',
        label: 'En recherche',
        icon: '🔍',
        description: 'À la recherche d\'un emploi'
    }
];

const selectOccupation = (occupation: string) => {
    emit('update:modelValue', occupation);
    emit('next');
};
</script>

<template>
    <div class="flex flex-col items-center w-full max-w-md mx-auto p-6">
        <h2 class="text-2xl font-bold mb-8 text-gray-800">Quelle est ta situation professionnelle ?</h2>

        <div class="grid grid-cols-2 gap-4 w-full">
            <button v-for="occupation in occupations" :key="occupation.id" @click="selectOccupation(occupation.id)"
                class="flex flex-col items-center p-6 rounded-2xl border-2 transition-all duration-300" :class="[
                    modelValue === occupation.id
                        ? 'border-secondary-500 bg-secondary-50'
                        : 'border-gray-200 hover:border-secondary-300'
                ]">
                <span class="text-4xl mb-3">{{ occupation.icon }}</span>
                <span class="text-lg font-medium mb-1" :class="[
                    modelValue === occupation.id ? 'text-secondary-600' : 'text-gray-700'
                ]">{{ occupation.label }}</span>
                <span class="text-sm text-gray-500">{{ occupation.description }}</span>
            </button>
        </div>
    </div>
</template>