import { ref } from "vue";
import { defineStore } from "pinia";
import { useStorage } from "@vueuse/core";

export const useDarkModeStore = defineStore("darkMode", () => {
    const isDark = ref(localStorage.getItem("theme") == "dark");

    document.documentElement.classList.toggle("dark", isDark.value);

    function toggleDarkMode() {
        isDark.value = !isDark.value;
        document.documentElement.classList.toggle("dark", isDark.value);
    }

    return { isDark, toggleDarkMode };
});
