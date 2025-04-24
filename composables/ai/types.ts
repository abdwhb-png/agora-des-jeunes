import type { Ref } from "vue";

export interface Message {
    id: string;
    content: string;
    role: "user" | "assistant" | "system";
    createdAt: number;
}

export type Provider = "openai" | "groq" | "gemini";

export interface AiConfig {
    provider: Provider;
    apiKey: string;
    model?: string;
    temperature?: number;
    maxTokens?: number;
}

export interface StreamResponse {
    isLoading: boolean;
    error: string | null;
    data: string | null;
    done: boolean;
}

export interface UseAiReturn {
    messages: Ref<Message[]>;
    isLoading: Ref<boolean>;
    error: Ref<string | null>;
    append: (content: string, role?: Message["role"]) => Promise<void>;
    send: (content: string) => Promise<void>;
    setConfig: (config: Partial<AiConfig>) => void;
    reset: () => void;
}
