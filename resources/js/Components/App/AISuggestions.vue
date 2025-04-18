<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    suggestions: {
        type: Array,
        default: () => []
    },
    isLoading: {
        type: Boolean,
        default: false
    }
});

const selectedSuggestion = ref(null);

const emit = defineEmits(['apply']);

function selectSuggestion(suggestion) {
    selectedSuggestion.value = suggestion === selectedSuggestion.value ? null : suggestion;
}

function applySuggestion() {
    if (selectedSuggestion.value) {
        emit('apply', selectedSuggestion.value);
        selectedSuggestion.value = null;
    }
}

// Group suggestions by type for rendering
const groupedSuggestions = computed(() => {
    const grouped = {};
    props.suggestions.forEach(suggestion => {
        if (!grouped[suggestion.type]) {
            grouped[suggestion.type] = [];
        }
        grouped[suggestion.type].push(suggestion);
    });
    return grouped;
});
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                    clip-rule="evenodd" />
            </svg>
            Suggestions de l'IA
        </h2>

        <div v-if="isLoading" class="flex justify-center items-center py-8">
            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="ml-3 text-gray-600">Génération des suggestions...</span>
        </div>

        <div v-else-if="suggestions.length === 0" class="text-center py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
            <p class="mt-4 text-gray-500">Commencez à écrire pour obtenir des suggestions de l'IA</p>
        </div>

        <template v-else>
            <!-- Group by suggestion type -->
            <div v-for="(group, type) in groupedSuggestions" :key="type" class="mb-6">
                <h3 class="text-sm font-medium text-gray-700 mb-3 capitalize">{{ type }}s</h3>
                <div class="space-y-3">
                    <div v-for="suggestion in group" :key="suggestion.id"
                        class="p-4 border rounded-lg cursor-pointer transition-colors duration-200"
                        :class="selectedSuggestion === suggestion ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300'"
                        @click="selectSuggestion(suggestion)">
                        <div class="flex items-center mb-2">
                            <span class="px-2 py-1 text-xs rounded-full" :class="{
                                'bg-blue-100 text-blue-800': type === 'amélioration',
                                'bg-green-100 text-green-800': type === 'idée',
                                'bg-purple-100 text-purple-800': type === 'référence',
                                'bg-yellow-100 text-yellow-800': type === 'conseil'
                            }">
                                {{ type }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-700">{{ suggestion.text }}</p>
                    </div>
                </div>
            </div>

            <div v-if="selectedSuggestion" class="mt-4 flex justify-end">
                <button @click="applySuggestion"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Appliquer
                </button>
            </div>
        </template>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-md font-medium text-gray-900 mb-3">Demander à l'IA</h3>
            <div class="flex">
                <input type="text" placeholder="Pose une question à l'IA..."
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <button
                    class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>