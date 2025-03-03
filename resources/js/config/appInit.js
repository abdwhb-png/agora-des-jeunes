import { ZiggyVue } from "../../../vendor/tightenco/ziggy";
import { createPinia } from "pinia";
import * as Sentry from "@sentry/vue";
import { pt as DataTablePt } from "@/utils/dataTable";

import PrimeVue from "primevue/config";
import ToastService from "primevue/toastservice";
import ConfirmationService from "primevue/confirmationservice";
import AnimateOnScroll from "primevue/animateonscroll";
import FocusTrap from "primevue/focustrap";
import Tooltip from "primevue/tooltip";

import { getPreset } from "./primePreset";
import primeLocale from "./primeLocale";

export const appName = import.meta.env.VITE_APP_NAME || "Agora des Jeunes";
export const frontendUrl =
    import.meta.env.VITE_FRONTEND_URL || "https://home.agora-jeunes.com";
export const appUrl =
    import.meta.env.VITE_APP_URL || "https://agora-jeunes.com";
export const cvBuilderUrl =
    import.meta.env.VITE_CV_BUILDER_URL ||
    "https://cv-builder.agora-jeunes.com";

export function appDefault(app) {
    app.config.globalProperties.$route = route;
    app.use(ZiggyVue);
}

export function initPinia(app) {
    app.config.globalProperties.$route = route;
    const pinia = createPinia();
    app.use(pinia);
}

export function initSentry(app) {
    const sentryDns = import.meta.env.VITE_SENTRY_DSN_PUBLIC;
    Sentry.init({
        app,
        dsn: sentryDns,
        ignoreErrors: ["GraphQLError", /^Exact Match Message$/],
        integrations: [
            Sentry.browserTracingIntegration({ route }),
            Sentry.replayIntegration(),
        ],

        // Tracing
        tracesSampleRate: 1.0, //  Capture 100% of the transactions
        // Set 'tracePropagationTargets' to control for which URLs distributed tracing should be enabled
        tracePropagationTargets: ["localhost", appUrl],

        // Session Replay
        replaysSessionSampleRate: 0.1, // This sets the sample rate at 10%. You may want to change it to 100% while in development and then sample at a lower rate in production.
        replaysOnErrorSampleRate: 1.0, // If you're not already sampling the entire session, change the sample rate to 100% when sampling sessions where errors occur.
    });
}

export function initPrime(app) {
    const MyPreset = getPreset();

    app.use(PrimeVue, {
        theme: {
            preset: MyPreset,
            options: {
                darkModeSelector: ".dark",
            },
        },
        locale: primeLocale(),
        ripple: true,
        pt: {
            dataTable: DataTablePt,
            editor: {
                codeBlock: (props) => ({
                    style: "display: none",
                }),
            },
        },
    })
        .use(ToastService)
        .use(ConfirmationService)
        .directive("animateonscroll", AnimateOnScroll)
        .directive("focustrap", FocusTrap)
        .directive("tooltip", Tooltip);
}
