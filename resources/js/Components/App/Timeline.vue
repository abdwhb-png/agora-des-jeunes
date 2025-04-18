<script setup>
import { computed } from 'vue';

const props = defineProps({
    activities: {
        type: Array,
        default: () => []
    },
    loading: {
        type: Boolean,
        default: false
    }
});

// Format date for display
function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffDays = Math.floor((now - date) / (1000 * 60 * 60 * 24));

    if (diffDays === 0) {
        return "Aujourd'hui";
    } else if (diffDays === 1) {
        return "Hier";
    } else if (diffDays < 7) {
        return `Il y a ${diffDays} jours`;
    } else {
        return date.toLocaleDateString('fr-FR', {
            day: 'numeric',
            month: 'short',
            year: diffDays > 365 ? 'numeric' : undefined
        });
    }
}

// Get status color for each activity type
function getStatusColor(type) {
    switch (type) {
        case 'milestone':
            return 'bg-indigo-100 text-indigo-800';
        case 'update':
            return 'bg-blue-100 text-blue-800';
        case 'comment':
            return 'bg-green-100 text-green-800';
        case 'ai_suggestion':
            return 'bg-purple-100 text-purple-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}

const sortedActivities = computed(() => {
    return [...props.activities].sort((a, b) =>
        new Date(b.timestamp) - new Date(a.timestamp)
    );
});
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                    clip-rule="evenodd" />
            </svg>
            Timeline du projet
        </h2>

        <div v-if="loading" class="flex justify-center items-center py-8">
            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="ml-3 text-gray-600">Chargement des activités...</span>
        </div>

        <div v-else-if="activities.length === 0" class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="mt-4 text-gray-500">Aucune activité à afficher pour le moment</p>
        </div>

        <div v-else class="relative">
            <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200"></div>
            <div v-for="activity in sortedActivities" :key="activity.id" class="relative flex items-start mb-6">
                <div class="absolute left-0 mt-1 flex items-center justify-center">
                    <div class="h-4 w-4 rounded-full border-2 border-indigo-600 bg-white"></div>
                </div>
                <div class="ml-16">
                    <div class="flex flex-wrap items-center gap-2">
                        <h3 class="text-base font-medium text-gray-900">{{ activity.title }}</h3>
                        <span class="text-xs px-2 py-0.5 rounded-full" :class="getStatusColor(activity.type)">
                            {{ formatDate(activity.timestamp) }}
                        </span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">{{ activity.description }}</p>

                    <!-- AI Suggestion -->
                    <div v-if="activity.type === 'ai_suggestion'"
                        class="mt-2 p-3 bg-purple-50 rounded-md border border-purple-100">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600 mr-1"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-medium text-purple-800">Suggestion de l'IA</span>
                        </div>
                        <p class="text-sm text-gray-700">{{ activity.aiContent }}</p>
                    </div>

                    <!-- Comments -->
                    <div v-if="activity.comments && activity.comments.length > 0" class="mt-2">
                        <div v-for="comment in activity.comments" :key="comment.id"
                            class="mt-2 p-2 bg-gray-50 rounded-md text-sm">
                            <div class="flex items-center">
                                <div
                                    class="h-6 w-6 rounded-full bg-gray-300 flex items-center justify-center text-xs font-medium text-gray-700 mr-2">
                                    {{ comment.author.substring(0, 1).toUpperCase() }}
                                </div>
                                <span class="font-medium text-gray-900">{{ comment.author }}</span>
                                <span class="ml-2 text-xs text-gray-500">{{ formatDate(comment.timestamp) }}</span>
                            </div>
                            <p class="mt-1 text-gray-600">{{ comment.text }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Comment/Activity Button -->
        <div class="mt-6 flex justify-end">
            <button
                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter une activité
            </button>
        </div>
    </div>
</template>