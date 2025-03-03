import { createInertiaApp } from "@inertiajs/vue3";
import createServer from "@inertiajs/vue3/server";
import { renderToString } from "@vue/server-renderer";
import { createSSRApp, h } from "vue";

import { initPinia, initPrime, appDefault, appName } from "./config/appInit";

// Importer la fonction d'enregistrement des composants
import registerComponents from "./config/appComponents";

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title ? title + " - " : ""}${appName}`,
        resolve: (name) => {
            const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
            return pages[`./Pages/${name}.vue`];
        },
        setup({ App, props, plugin }) {
            const app = createSSRApp({
                render: () => h(App, props),
            });

            app.use(plugin);

            appDefault(app);
            initPinia(app);
            initPrime(app);

            // 🔹 Enregistrer les composants via la fonction importée
            registerComponents(app);

            return app;
        },
    }),
);
