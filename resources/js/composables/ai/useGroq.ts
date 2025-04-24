// useGroq.ts
import Groq from "groq-sdk";
import { useExternalApi } from "../useExternalApi";
import { useApi } from "../useApi";

// Types
interface AiUsageData {
    input_text: Groq.Chat.CompletionCreateParams;
    output_text: Groq.Chat.ChatCompletionChoice[];
    ai: string;
    tokens_used: number;
    metadata: Groq.Chat.ChatCompletion;
}

interface ChatResponse {
    success: boolean;
    output: string;
    error?: string;
}

// Configuration
const CONFIG = {
    API_KEY: import.meta.env.VITE_GROQ_API_KEY,
    TIMEOUT: Number(import.meta.env.VITE_GROQ_TIMEOUT) || 20 * 1000,
    MODEL: "llama3-8b-8192" as const,
} as const;

// Error handling
class GroqError extends Error {
    constructor(
        message: string,
        public originalError?: unknown,
    ) {
        super(message);
        this.name = "GroqError";
    }
}

async function fallBack(
    error: unknown,
    userInput: string,
    systemPrompt: string = "",
): Promise<ChatResponse> {
    try {
        if (error instanceof Groq.APIError) {
            logger.error("Groq API Error:", error);
        }
        const { api } = useExternalApi();
        const { data } = await api.post<ChatResponse>("/ai/chat", {
            user_input: userInput,
            system_prompt: systemPrompt || null,
        });

        return data;
    } catch (fallbackError) {
        logger.error("Fallback failed:", fallbackError);
        return {
            success: false,
            output: "Erreur lors de la requête vers l'IA.",
            error:
                fallbackError instanceof Error
                    ? fallbackError.message
                    : "Unknown error",
        };
    }
}

async function setAiUsage(data: AiUsageData): Promise<void> {
    try {
        const { api } = useApi();
        const response = await api.post("/ai-usage", data);
        logger.debug("AI usage logged:", response);
    } catch (error) {
        logger.error("Failed to log AI usage:", error);
    }
}

export function useGroq() {
    const client = new Groq({
        apiKey: CONFIG.API_KEY,
        dangerouslyAllowBrowser: true,
        timeout: CONFIG.TIMEOUT,
    });

    async function mainChat(
        userInput: string,
        systemPrompt: string = "",
    ): Promise<ChatResponse> {
        try {
            const params: Groq.Chat.CompletionCreateParams = {
                messages: [
                    {
                        role: "user",
                        content: userInput,
                    },
                ],
                model: CONFIG.MODEL,
            };

            if (systemPrompt) {
                params.messages.unshift({
                    role: "system",
                    content: systemPrompt,
                });
            }

            const chatCompletion = await client.chat.completions.create(params);
            const answer = chatCompletion.choices[0]?.message?.content;

            if (!answer) {
                throw new GroqError("No response content received");
            }

            await setAiUsage({
                input_text: params,
                output_text: chatCompletion.choices,
                ai: "groq",
                tokens_used: chatCompletion.usage.total_tokens,
                metadata: chatCompletion,
            });

            return {
                success: true,
                output: answer,
            };
        } catch (error) {
            return fallBack(error, userInput, systemPrompt);
        }
    }

    return { client, mainChat };
}

// Logger utility (à implémenter selon vos besoins)
const logger = {
    debug: (message: string, ...args: unknown[]) =>
        console.debug(message, ...args),
    error: (message: string, ...args: unknown[]) =>
        console.error(message, ...args),
};
