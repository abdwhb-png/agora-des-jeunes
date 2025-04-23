<template>
    <div>
        <!-- Back Button -->
        <div
            class="border border-gray-200 dark:border-gray-700 rounded-lg p-3 mb-4 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
            @click="$emit('back')"
        >
            <div class="flex items-center text-gray-500 dark:text-gray-400">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
                Retour à la recherche générique...
            </div>
        </div>

        <!-- Original Query -->
        <div class="flex items-center mb-3">
            <div class="bg-blue-500 rounded-full p-1 mr-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 text-white"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>
            <div class="text-gray-900 dark:text-white">
                {{ `Informations sur "${query}"` }}
            </div>
        </div>

        <!-- AI Response -->
        <div
            class="text-gray-800 dark:text-gray-300 mb-4 prose dark:prose-invert max-w-none"
        >
            <div v-if="aiResponse">
                <h3>{{ aiResponse.title }}</h3>
                <p>{{ aiResponse.description }}</p>
                <ul>
                    <li v-for="(point, i) in aiResponse.points" :key="i">
                        {{ point }}
                    </li>
                </ul>
                <pre
                    v-if="aiResponse.code"
                    class="bg-gray-100 dark:bg-gray-700 p-3 rounded-md overflow-x-auto"
                ><code>{{ aiResponse.code }}</code></pre>
            </div>
            <div v-else class="text-center py-4">
                <div class="animate-pulse">Génération de la réponse...</div>
            </div>
        </div>

        <!-- Related Topics -->
        <div class="flex flex-wrap gap-2 mb-3">
            <span
                v-for="(tag, i) in relatedTopics"
                :key="i"
                @click="emit('search', tag)"
                class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-md text-sm cursor-pointer"
                >{{ tag }}</span
            >
        </div>

        <!-- Feedback Buttons -->
        <div class="flex justify-end mt-3">
            <button
                class="text-gray-500 dark:text-gray-400 mx-1 hover:text-gray-700 dark:hover:text-gray-200 transition-colors"
                @click="handleFeedback('thumbsUp')"
                :class="{
                    'text-green-500 hover:text-green-600':
                        feedback === 'thumbsUp',
                }"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"
                    />
                </svg>
            </button>
            <button
                class="text-gray-500 dark:text-gray-400 mx-1 hover:text-gray-700 dark:hover:text-gray-200 transition-colors"
                @click="handleFeedback('thumbsDown')"
                :class="{
                    'text-red-500 hover:text-red-600':
                        feedback === 'thumbsDown',
                }"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"
                    />
                </svg>
            </button>
            <button
                class="text-gray-500 dark:text-gray-400 mx-1 hover:text-gray-700 dark:hover:text-gray-200 transition-colors"
                @click="handleFeedback('regenerate')"
                :class="{
                    'text-blue-500 hover:text-blue-600':
                        feedback === 'regenerate',
                }"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"
                    />
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from "vue";

interface AiResponse {
    title: string;
    description: string;
    points: string[];
    code?: string;
}

// Props
const props = defineProps<{
    query: string;
}>();

// Emits
const emit = defineEmits<{
    close: [];
    back: [];
    search: [query: string];
    feedback: [type: "thumbsUp" | "thumbsDown" | "regenerate"];
}>();

// State
const aiResponse = ref<AiResponse | null>(null);
const feedback = ref<"thumbsUp" | "thumbsDown" | "regenerate" | null>(null);
const relatedTopics = ref([
    "Accueil",
    "Foire Aux Questions",
    "A propos",
    "Contact",
    "Blog",
    "Confidentialité",
]);

// Methods
const generateAiResponse = () => {
    aiResponse.value = null;
    feedback.value = null;

    // Simulate AI response generation with a delay
    setTimeout(() => {
        aiResponse.value = {
            title: `Réponse de l'IA à votre requête`,
            description: `Voici ce que j'ai trouvé à propos de "${props.query}" dans notre documentation :`,
            points: [
                `"${props.query}" est un concept clé dans notre plateforme qui...`,
                `Impossible de continuer la génération de la réponse.`,
            ],
            //         code: `// Exemple de code pour ${props.query}
            // const client = new ApiClient({
            //     apiKey: 'votre-clé-api',
            //     options: {
            //     ${props.query}: true,
            //     timeout: 5000
            //     }
            // });`,
        };
    }, 1500);
};

const handleFeedback = (type: "thumbsUp" | "thumbsDown" | "regenerate") => {
    feedback.value = type;
    emit("feedback", type);

    if (type === "regenerate") {
        generateAiResponse();
    }
};

// Watchers
watch(
    () => props.query,
    () => {
        generateAiResponse();
    },
    { immediate: true },
);

// Lifecycle
onMounted(() => {
    // Any additional setup can go here
});
</script>

<style scoped>
:deep(.prose) {
    max-width: none;
}

:deep(.prose pre) {
    margin: 1em 0;
}

:deep(.prose code) {
    color: inherit;
}
</style>
