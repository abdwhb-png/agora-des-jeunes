/// <reference types="vite/client" />

interface ImportMetaEnv {
    readonly VITE_AI_PROVIDER: "openai" | "groq";
    readonly VITE_OPENAI_API_KEY: string;
    readonly VITE_GROQ_API_KEY: string;
}

interface ImportMeta {
    readonly env: ImportMetaEnv;
}
