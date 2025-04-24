import { ref } from "vue";
import type { Message, AiConfig, UseAiReturn } from "./types";
import type { AiProvider } from "./providers/base";

const defaultConfig: AiConfig = {
    provider: "openai",
    apiKey: "",
    model: "gpt-3.5-turbo",
    temperature: 0.7,
    maxTokens: 1000,
};

export function useAi(initialConfig: Partial<AiConfig> = {}): UseAiReturn {
    const config = ref<AiConfig>({
        ...defaultConfig,
        ...initialConfig,
    });

    const messages = ref<Message[]>([]);
    const isLoading = ref(false);
    const error = ref<string | null>(null);

    let provider: AiProvider | null = null;

    async function initProvider() {
        if (!provider) {
            const { provider: providerName } = config.value;
            try {
                const ProviderModule = await import(
                    `./providers/${providerName}`
                );
                provider = new ProviderModule.default(config.value);
            } catch (e) {
                error.value = `Failed to load ${providerName} provider`;
                throw e;
            }
        }
    }

    async function append(content: string, role: Message["role"] = "user") {
        const message: Message = {
            id: crypto.randomUUID(),
            content,
            role,
            createdAt: Date.now(),
        };
        messages.value.push(message);
    }

    async function send(content: string) {
        try {
            await append(content);
            isLoading.value = true;
            error.value = null;

            await initProvider();
            if (!provider) return;

            const stream = provider.send(messages.value);
            let assistantMessage = "";

            for await (const chunk of stream) {
                assistantMessage += chunk;
            }

            await append(assistantMessage, "assistant");
        } catch (e) {
            error.value = e instanceof Error ? e.message : "An error occurred";
        } finally {
            isLoading.value = false;
        }
    }

    function setConfig(newConfig: Partial<AiConfig>) {
        config.value = {
            ...config.value,
            ...newConfig,
        };
        if (provider) {
            provider.setConfig(newConfig);
        }
    }

    function reset() {
        messages.value = [];
        error.value = null;
        isLoading.value = false;
    }

    return {
        messages,
        isLoading,
        error,
        append,
        send,
        setConfig,
        reset,
    };
}

export * from "./types";
export { BaseAiProvider } from "./providers/base";
