import { ref, onMounted, onUnmounted } from "vue";

const getMatches = (query) => {
    // Prevents SSR issues
    if (typeof window !== "undefined") {
        return window.matchMedia(query).matches;
    }
    return false;
};

const useMediaQuery = (query) => {
    const matches = ref(getMatches(query));

    const handleChange = () => {
        matches.value = getMatches(query);
    };

    onMounted(() => {
        const matchMedia = window.matchMedia(query);

        // Triggered at the first client-side load
        handleChange();

        // Listen for changes
        matchMedia.addEventListener("change", handleChange);
    });

    onUnmounted(() => {
        const matchMedia = window.matchMedia(query);
        matchMedia.removeEventListener("change", handleChange);
    });

    return matches;
};

export { useMediaQuery };
