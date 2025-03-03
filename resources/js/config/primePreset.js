import { definePreset } from "@primevue/themes";
import Aura from "@primevue/themes/aura";

export function getPreset(type = "") {
    const preset = type === "gestion" ? gestionPreset() : appPreset();

    return definePreset(Aura, preset);
}

export function gestionPreset() {
    return {
        semantic: {
            primary: {
                50: "{blue.50}",
                100: "{blue.100}",
                200: "{blue.200}",
                300: "{blue.300}",
                400: "{blue.400}",
                500: "{blue.500}",
                600: "{blue.600}",
                700: "{blue.700}",
                800: "{blue.800}",
                900: "{blue.900}",
                950: "{blue.950}",
            },
        },
    };
}

export function appPreset() {
    return {
        semantic: {
            primary: {
                50: "{orange.50}",
                100: "{orange.100}",
                200: "{orange.200}",
                300: "{orange.300}",
                400: "{orange.400}",
                500: "{orange.500}",
                600: "{orange.600}",
                700: "{orange.700}",
                800: "{orange.800}",
                900: "{orange.900}",
                950: "{orange.950}",
            },
        },
    };
}
