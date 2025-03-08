// useGroq.ts
import Groq from "groq-sdk";
import { useExternalApi } from "./useExternalApi";
import { useApi } from "./useApi";

const apiKey = import.meta.env.VITE_GROQ_API_KEY;

interface ReturnResponse {
    success: boolean;
    output: string;
}

async function fallBack(
    error: any,
    userInput: string,
    systemPrompt: string = "",
): Promise<ReturnResponse> {
    try {
        if (error instanceof Groq.APIError) {
            console.error("API Error -> ", error);
        }
        const { api } = useExternalApi();
        const { data } = await api.post("/ai/chat", {
            user_input: userInput,
            system_prompt: systemPrompt || null,
        });

        return data;
    } catch (error) {
        console.error("Fallback failed : ", error);
        return {
            success: false,
            output: "Erreur lors de la requête vers l'IA.",
        };
    }
}

async function setAiUsage(data: Object) {
    const { api } = useApi();
    const res = await api.post("/ai-usage", data);
    console.log(res);
}

export function useGroq() {
    const client = new Groq({
        apiKey: apiKey,
        dangerouslyAllowBrowser: true,
        timeout: 20 * 1000, // 20 seconds (default is 1 minute)
    });

    async function mainChat(
        userInput: string,
        systemPrompt: string = "",
    ): Promise<ReturnResponse> {
        try {
            const params: Groq.Chat.CompletionCreateParams = {
                messages: [
                    {
                        role: "user",
                        content: userInput,
                    },
                ],
                model: "llama3-8b-8192",
            };

            if (systemPrompt) {
                params.messages.push({ role: "system", content: systemPrompt });
            }

            const chatCompletion: Groq.Chat.ChatCompletion =
                await client.chat.completions.create(params);

            const answer = chatCompletion.choices[0].message.content;

            console.log(answer);

            setAiUsage({
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
        } catch (err) {
            return fallBack(err, userInput, systemPrompt);
        }
    }

    return { client, mainChat };
}
