import { defineStore } from "pinia";
import { useStorage } from "@vueuse/core";

interface Language {
    name: string;
    code: string;
    flag: string;
}

export const useLanguageStore = defineStore("language", () => {
    const languages = [
        {
            name: "Français",
            code: "fr",
            flag: "https://keenthemes.com/static/metronic/tailwind/dist/assets/media/flags/france.svg",
        },
        {
            name: "English",
            code: "en",
            flag: "https://keenthemes.com/static/metronic/tailwind/dist/assets/media/flags/united-states.svg",
        },
        // {
        //     name: "Spanish",
        //     flag: "https://keenthemes.com/static/metronic/tailwind/dist/assets/media/flags/spain.svg",
        //     code: "es",
        // },
        // {
        //     name: "German",
        //     flag: "https://keenthemes.com/static/metronic/tailwind/dist/assets/media/flags/germany.svg",
        //     code: "de",
        // },
    ];

    const currentLanguage = useStorage("currentLanguage", languages[0]);

    function changeLanguage(item: Language) {
        currentLanguage.value = item;
        window.location.reload();
    }

    return { currentLanguage, languages, changeLanguage };
});
