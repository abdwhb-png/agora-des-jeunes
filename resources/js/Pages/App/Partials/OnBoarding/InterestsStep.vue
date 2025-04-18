<script setup lang="ts">
import { ref, computed } from 'vue';

const emit = defineEmits<{
    (e: 'update:modelValue', value: string[]): void;
    (e: 'next'): void;
}>();

const props = defineProps<{
    modelValue: string[];
}>();

const interests = [
    { id: 'entrepreneuriat', label: 'Entrepreneuriat', icon: '🚀' },
    { id: 'creation-projet', label: 'Création de projet', icon: '📝' },
    { id: 'recherche-emploi', label: 'Recherche d\'emploi', icon: '🔍' },
    { id: 'etudes-etranger', label: 'Études à l\'étranger', icon: '🌍' },
    { id: 'art', label: 'Art', icon: '🎨' },
    { id: 'musique', label: 'Musique', icon: '🎵' },
    { id: 'jeux-video', label: 'Gaming', icon: '🎮' },
    { id: 'nature', label: 'Nature', icon: '🌲' },
    { id: 'voyage', label: 'Voyage', icon: '✈️' },
    { id: 'danse', label: 'Danse', icon: '💃' },
    { id: 'ecriture', label: 'Écriture', icon: '✍️' },
    { id: 'intelligence-artificielle', label: 'IA', icon: '🤖' },
    { id: 'travail', label: 'Travail', icon: '💼' },
    { id: 'lecture', label: 'Livres', icon: '📚' },
    { id: 'sport', label: 'Sport', icon: '⚽' },
    { id: 'cinema', label: 'Cinéma', icon: '🎬' },
    { id: 'peinture', label: 'Peinture', icon: '🖌️' },
    { id: 'cuisine', label: 'Cuisine', icon: '🍳' },
    { id: 'fitness', label: 'Fitness', icon: '💪' },
    { id: 'langues', label: 'Langues', icon: '🗣️' },
    { id: 'mode', label: 'Mode', icon: '👗' },
    { id: 'animaux', label: 'Animaux', icon: '🐾' }
];

const selectedInterests = ref<string[]>(props.modelValue);

const isValid = computed(() => {
    return selectedInterests.value.length >= 3;
});

const toggleInterest = (interestId: string) => {
    const index = selectedInterests.value.indexOf(interestId);
    if (index === -1) {
        if (selectedInterests.value.length < 5) {
            selectedInterests.value.push(interestId);
        }
    } else {
        selectedInterests.value.splice(index, 1);
    }
    emit('update:modelValue', selectedInterests.value);
};

const handleNext = () => {
    if (isValid.value) {
        emit('next');
    }
};

const resetInterests = () => {
    selectedInterests.value = [];
    emit('update:modelValue', []);
};
</script>

<template>
    <div class="flex flex-col items-center w-full max-w-md mx-auto p-6">
        <h2 class="text-2xl font-bold mb-2 text-gray-800">Tes centres d'intérêt</h2>
        <p class="text-gray-600 mb-4 text-center">Sélectionne entre 3 à 5 centres d'intérêt</p>
        <div v-if="selectedInterests.length > 0" class="flex justify-center items-center mb-8">
            <UiButton @click="resetInterests">
                Réinitialiser
                <i class="pi pi-times"></i>
            </UiButton>
        </div>

        <div class="grid grid-cols-3 gap-3 w-full mb-6">
            <button v-for="interest in interests" :key="interest.id" @click="toggleInterest(interest.id)"
                class="flex flex-col items-center p-3 rounded-xl border transition-all duration-300" :class="[
                    selectedInterests.includes(interest.id)
                        ? 'border-secondary-500 bg-secondary-50'
                        : 'border-gray-200 hover:border-secondary-300',
                    selectedInterests.length >= 5 && !selectedInterests.includes(interest.id)
                        ? 'opacity-50 cursor-not-allowed'
                        : ''
                ]" :disabled="selectedInterests.length >= 5 && !selectedInterests.includes(interest.id)">
                <span class="text-2xl mb-2">{{ interest.icon }}</span>
                <span class="text-sm font-medium text-center" :class="[
                    selectedInterests.includes(interest.id) ? 'text-secondary-600' : 'text-gray-700'
                ]">{{ interest.label }}</span>
            </button>
        </div>

        <button @click="handleNext"
            class="w-full py-3 px-4 rounded-xl text-white font-medium transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
            :class="[
                isValid
                    ? 'bg-gradient-to-r from-secondary-500 to-secondary-600 hover:from-secondary-600 hover:to-secondary-700'
                    : 'bg-gray-300'
            ]" :disabled="!isValid">
            Continuer
        </button>
    </div>
</template>