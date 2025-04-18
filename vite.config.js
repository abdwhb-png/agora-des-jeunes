import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vueJsx from "@vitejs/plugin-vue-jsx";
import Components from "unplugin-vue-components/vite";
import { PrimeVueResolver } from "@primevue/auto-import-resolver";
import { sentryVitePlugin } from "@sentry/vite-plugin";
import { ViteImageOptimizer } from 'vite-plugin-image-optimizer';
import { fileURLToPath, URL } from "node:url";

const vueOptions = {
    template: {
        transformAssetUrls: {
            base: null,
            includeAbsolute: false,
        },
    },
};

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/home.css",
                "resources/css/app.css",
                "resources/scss/app.scss",
                "resources/js/app.js",
            ],
            ssr: "resources/js/ssr.js",
            refresh: false,
        }),
        vue(vueOptions),
        vueJsx(),
        Components({
            resolvers: [PrimeVueResolver()],
        }),
        sentryVitePlugin({
            org: "your-devlab",
            project: "agora-jeunes-vue",
        }),
        ViteImageOptimizer({
            test: /\.(jpe?g|png|gif|webp|svg)$/i,
            includePublic: true, // Important pour les images dans public
            dirs: ['public/images'], // Spécifier les dossiers à optimiser
            png: {
                quality: 80
            },
            jpeg: {
                quality: 80
            },
            jpg: {
                quality: 80
            }
        }),
    ],

    resolve: {
        alias: {
            "@": "/resources/js",
            "@css": "/resources/css",
            "@resources": "/resources",
            "@metronic": "/resources/metronic",
            "@public": fileURLToPath(new URL("public", import.meta.url)),
        },
    },

    build: {
        sourcemap: true,
    },
});
