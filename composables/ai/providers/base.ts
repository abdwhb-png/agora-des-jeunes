import type { AiConfig, Message } from "../types";

export interface AiProvider {
    config: AiConfig;
    send: (messages: Message[]) => AsyncGenerator<string, void, unknown>;
    setConfig: (config: Partial<AiConfig>) => void;
}

export abstract class BaseAiProvider implements AiProvider {
    protected _config: AiConfig;

    constructor(config: AiConfig) {
        this._config = config;
    }

    get config(): AiConfig {
        return this._config;
    }

    setConfig(config: Partial<AiConfig>): void {
        this._config = {
            ...this._config,
            ...config,
        };
    }

    abstract send(messages: Message[]): AsyncGenerator<string, void, unknown>;
}
