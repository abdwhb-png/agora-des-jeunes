<script setup>
import { ref, computed, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Navigation from '@/Components/App/Navigation.vue';
import AISuggestions from '@/Components/App/AISuggestions.vue';

const title = "Agora IA - Rédaction assistée";
const content = ref('');
const suggestions = ref([]);
const isGenerating = ref(false);

// Mock suggestions - in a real app, these would come from an API call
function generateSuggestions() {
    isGenerating.value = true;
    setTimeout(() => {
        suggestions.value = [
            {
                id: 1,
                type: 'amélioration',
                text: 'Voici une formulation plus claire pour ce paragraphe: "L\'intelligence artificielle transforme notre façon de travailler, offrant des outils innovants pour améliorer la productivité."'
            },
            {
                id: 2,
                type: 'idée',
                text: 'Vous pourriez développer l\'idée de l\'impact de l\'IA sur la créativité humaine.'
            },
            {
                id: 3,
                type: 'référence',
                text: 'Selon une étude récente de Stanford (2023), 67% des professionnels rapportent une augmentation de productivité grâce aux outils d\'IA.'
            }
        ];
        isGenerating.value = false;
    }, 1500);
}

watch(content, (newContent) => {
    if (newContent.length > 50 && !isGenerating.value && suggestions.value.length === 0) {
        generateSuggestions();
    }
}, { debounce: 500 });

function applySuggestion(suggestion) {
    if (suggestion && suggestion.type === 'amélioration') {
        // In a real app, this would insert the suggestion at the cursor position
        content.value += '\n\n' + suggestion.text;
    }
}

const wordCount = computed(() => {
    return content.value.split(/\s+/).filter(word => word.length > 0).length;
});
</script>

<template>

    <Head :title="title" />
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
        <!-- Navigation Bar -->
        <Navigation current-page="editor" />

        <!-- Main Content -->
        <main class="pt-16 pb-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="py-8">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Rédaction assistée</h1>
                            <p class="mt-2 text-gray-600">Écrivez avec l'aide de l'IA pour améliorer vos textes</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">{{ wordCount }} mots</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Editor Area -->
                    <div class="flex-1 bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center mb-4">
                            <div class="relative w-full max-w-md">
                                <input type="text" placeholder="Titre du document"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-lg font-medium">
                            </div>
                            <div class="flex space-x-2">
                                <button class="p-2 text-gray-500 hover:text-indigo-600 rounded-md hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                    </svg>
                                </button>
                                <button class="p-2 text-gray-500 hover:text-indigo-600 rounded-md hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <textarea v-model="content" rows="20" placeholder="Commencez à rédiger ici..."
                            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-gray-700"></textarea>
                    </div>

                    <!-- AI Sidebar -->
                    <div class="lg:w-1/3">
                        <AISuggestions :suggestions="suggestions" :is-loading="isGenerating" @apply="applySuggestion" />
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>