import { sentryVitePlugin } from "@sentry/vite-plugin";
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vueJsx from "@vitejs/plugin-vue-jsx";
import Components from "unplugin-vue-components/vite";
import { PrimeVueResolver } from "@primevue/auto-import-resolver";
import Imagemin from "unplugin-imagemin/vite";

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
        Imagemin({
            gifsicle: { optimizationLevel: 3 },
            mozjpeg: { quality: 80 },
            optipng: { optimizationLevel: 3 },
            svgo: { plugins: [{ removeViewBox: false }] },
        }),
        sentryVitePlugin({
            org: "your-devlab",
            project: "agora-jeunes-vue",
        }),
    ],

    resolve: {
        alias: {
            "@": "/resources/js",
            "@css": "/resources/css",
            "@assets": "/resources/assets",
            "@metronic": "/resources/metronic",
        },
    },

    build: {
        sourcemap: true,
    },
});
