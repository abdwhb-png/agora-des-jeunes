import "./bootstrap";
import "primeicons/primeicons.css";
import "@metronic/core/index";
import "@metronic/app/layouts/demo1";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

import {
    initPinia,
    initPrime,
    appName,
    appDefault,
    initSentry,
} from "./config/appInit";

// Importer la fonction d'enregistrement des composants
import registerComponents from "./config/appComponents";

createInertiaApp({
    title: (title) => `${title ? title + " - " : ""}${appName}`,

    progress: {
        color: "#4B5563",
    },

    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        ),

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);

        appDefault(app);
        initPinia(app);
        initPrime(app);
        // initSentry(app);

        // 🔹 Enregistrer les composants via la fonction importée
        registerComponents(app);

        return app.mount(el);
    },
});
