/// <reference types="vite/client" />
/// <reference path="../../env.d.ts" />

import { streamText, generateText } from "ai"; // Import streamText and generateText
import { createOpenAI } from "@ai-sdk/openai";
import { createGroq } from "@ai-sdk/groq";
import { ref, Ref } from "vue";

// Define the message interface
export interface Message {
    id: string;
    role: "user" | "assistant";
    content: string;
    createdAt?: Date;
}

// Define the chat state interface (optional, can just expose refs)
export interface ChatState {
    messages: Ref<Message[]>; // Make messages reactive in the state interface
    error: Ref<string | null>; // Make error reactive
    isLoading: Ref<boolean>; // Make isLoading reactive
}

// Type for messages compatible with AI SDK
type AIChatMessage = {
    role: "user" | "assistant";
    content: string;
};

// Define types for the AI providers
type OpenAIProvider = ReturnType<typeof createOpenAI>;
type GroqProvider = ReturnType<typeof createGroq>;

// Function to get the appropriate AI provider based on environment variables
function getProvider(): OpenAIProvider | GroqProvider {
    const aiProvider = import.meta.env.VITE_AI_PROVIDER;
    const openaiApiKey = import.meta.env.VITE_OPENAI_API_KEY;
    const groqApiKey = import.meta.env.VITE_GROQ_API_KEY; // Corrected typo here in previous version, ensuring it's correct now.

    if (!aiProvider) {
        throw new Error("VITE_AI_PROVIDER environment variable is not set.");
    }

    switch (aiProvider) {
        case "openai":
            if (!openaiApiKey) {
                throw new Error(
                    "VITE_OPENAI_API_KEY environment variable is not set for OpenAI provider.",
                );
            }
            return createOpenAI({ apiKey: openaiApiKey });
        case "groq":
            if (!groqApiKey) {
                throw new Error(
                    "VITE_GROQ_API_KEY environment variable is not set for Groq provider.",
                );
            }
            return createGroq({ apiKey: groqApiKey });
        default:
            throw new Error(
                `Unknown AI provider: ${aiProvider}. Supported providers are 'openai' and 'groq'.`,
            );
    }
}

// Vue 3 composable for AI chat functionality
export function useAi() {
    // Initialize reactive state using refs
    const messages: Ref<Message[]> = ref([]);
    const error: Ref<string | null> = ref(null);
    const isLoading: Ref<boolean> = ref(false);

    // Get the AI provider instance
    // We get it here so it's initialized when the composable is used
    let provider: OpenAIProvider | GroqProvider | null = null;
    try {
        provider = getProvider();
    } catch (e: any) {
        error.value = e.message;
        console.error("Failed to initialize AI provider:", e);
    }

    // Function to handle user input and stream AI response
    async function handleSubmit(content: string): Promise<void> {
        // Prevent sending empty messages
        if (!content.trim() || !provider) {
            if (!provider && !error.value) {
                error.value = "AI provider failed to initialize.";
            }
            return;
        }

        // Reset error and set loading state
        error.value = null;
        isLoading.value = true;

        // Add user message to the messages array
        const userMessage: Message = {
            id: crypto.randomUUID(), // Use crypto.randomUUID for unique IDs
            role: "user",
            content,
            createdAt: new Date(),
        };
        messages.value.push(userMessage);

        // Create a placeholder for the assistant's response
        const assistantMessage: Message = {
            id: crypto.randomUUID(),
            role: "assistant",
            content: "", // Start with empty content
            createdAt: new Date(),
        };
        messages.value.push(assistantMessage);

        // Prepare the chat messages for the AI SDK
        // Map Message objects to AIChatMessage objects
        const chatMessages: AIChatMessage[] = messages.value.map(
            ({ role, content }) => ({
                role,
                content,
            }),
        );

        try {
            // Use the streamText function from AI SDK
            const result = await streamText({
                // CORRECTED: Pass the model instance from the provider
                model:
                    provider instanceof createOpenAI
                        ? provider.chat("gpt-3.5-turbo") // Get OpenAI chat model instance
                        : provider.chat("mistral-saba-24b"), // Get Groq chat model instance
                messages: chatMessages,
            });

            // Iterate over the text stream and update the assistant message
            for await (const textPart of result.textStream) {
                // Append the new text part to the content of the last message (assistant)
                messages.value[messages.value.length - 1].content += textPart;
            }
        } catch (err: any) {
            // Catch and display any errors during the streaming process
            error.value =
                err instanceof Error
                    ? err.message
                    : "An error occurred while processing your request";
            console.error("Streaming error:", err);

            // Remove the assistant message placeholder if an error occurred before receiving content
            if (
                messages.value.length > 0 &&
                messages.value[messages.value.length - 1].content === ""
            ) {
                messages.value.pop();
            }
        } finally {
            // Always set loading to false after the process finishes or errors
            isLoading.value = false;
        }
    }

    // Function to clear all messages
    function clearMessages(): void {
        messages.value = [];
        error.value = null; // Also clear error on clearing messages
    }

    // Function to manually set messages (useful for loading saved state)
    function setMessages(newMessages: Message[]): void {
        messages.value = newMessages;
    }

    // Return the reactive state and functions from the composable
    return {
        // Expose refs directly for reactivity
        messages,
        error,
        isLoading,
        handleSubmit,
        clearMessages,
        setMessages,
        // Optionally expose a reactive state object (though exposing refs is more common in Vue 3 composables)
        // state: { messages, error, isLoading } // If you prefer a single state object
    };
}
