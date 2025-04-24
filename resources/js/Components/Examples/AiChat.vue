<script setup lang="ts">
import { ref } from "vue";
import { useAi, type Message } from "@/composables/aiSdk/useAi";

// Initialize the AI chat composable
const { messages, error, isLoading, handleSubmit, clearMessages } = useAi();

// Input field state
const userInput = ref("");

// Handle form submission
const onSubmit = async () => {
    const message = userInput.value;
    userInput.value = ""; // Clear input
    await handleSubmit(message);
};
</script>

<template>
    <div class="flex flex-col space-y-4 p-4 max-w-2xl mx-auto">
        <!-- Chat header -->
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">AI Chat Example</h2>
            <button
                @click="clearMessages"
                class="px-3 py-1 text-sm text-gray-600 hover:text-gray-800 border rounded"
            >
                Clear Chat
            </button>
        </div>

        <!-- Messages container -->
        <div
            class="flex-1 overflow-y-auto space-y-4 min-h-[300px] max-h-[500px] p-4 border rounded-lg"
        >
            <!-- Show error if present -->
            <div v-if="error" class="p-3 text-red-700 bg-red-50 rounded">
                {{ error }}
            </div>

            <!-- Message list -->
            <template v-if="messages.length">
                <div
                    v-for="message in messages"
                    :key="message.id"
                    :class="[
                        'p-3 rounded-lg max-w-[85%]',
                        message.role === 'user'
                            ? 'bg-blue-100 ml-auto'
                            : 'bg-gray-100',
                    ]"
                >
                    {{ message.content }}
                </div>
            </template>

            <!-- Empty state -->
            <div v-else class="text-center text-gray-500">
                No messages yet. Start a conversation!
            </div>

            <!-- Loading indicator -->
            <div
                v-if="isLoading"
                class="flex space-x-2 items-center text-gray-500"
            >
                <div class="animate-pulse">Thinking...</div>
            </div>
        </div>

        <!-- Input form -->
        <form @submit.prevent="onSubmit" class="flex space-x-2">
            <input
                v-model="userInput"
                type="text"
                placeholder="Type your message..."
                class="flex-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                :disabled="isLoading"
            />
            <button
                type="submit"
                :disabled="isLoading || !userInput.trim()"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50"
            >
                Send
            </button>
        </form>
    </div>
</template>

<style scoped>
/* Add any component-specific styles here */
</style>
