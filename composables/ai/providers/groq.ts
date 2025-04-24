import type { AiConfig, Message } from "../types";
import { BaseAiProvider } from "./base";

export class GroqProvider extends BaseAiProvider {
    async *send(messages: Message[]): AsyncGenerator<string, void, unknown> {
        const response = await fetch("/api/ai/chat", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                provider: "groq",
                messages: messages.map(({ content, role }) => ({
                    content,
                    role,
                })),
                stream: true,
            }),
        });

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.message || "Failed to communicate with Groq");
        }

        const reader = response.body?.getReader();
        if (!reader) {
            throw new Error("Response body is not readable");
        }

        const decoder = new TextDecoder();
        let buffer = "";

        try {
            while (true) {
                const { done, value } = await reader.read();

                if (done) {
                    if (buffer.length > 0) {
                        yield buffer;
                    }
                    break;
                }

                buffer += decoder.decode(value, { stream: true });
                const lines = buffer.split("\n");
                buffer = lines.pop() || "";

                for (const line of lines) {
                    if (line.startsWith("data: ")) {
                        const data = line.slice(6);
                        if (data === "[DONE]") continue;

                        try {
                            const parsed = JSON.parse(data);
                            if (parsed.error) {
                                throw new Error(parsed.error);
                            }
                            const content = parsed.choices?.[0]?.delta?.content;
                            if (content) {
                                yield content;
                            }
                        } catch (e) {
                            console.error("Failed to parse SSE message:", e);
                        }
                    }
                }
            }
        } finally {
            reader.releaseLock();
        }
    }
}
