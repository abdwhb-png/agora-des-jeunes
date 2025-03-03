import { onMounted, onUnmounted, ref } from "vue";

export function useViewport() {
    const height = ref(window.innerHeight);
    const width = ref(window.innerWidth);

    const isMobile = window.matchMedia("(max-width: 768px)").matches;

    const handleResize = () => {
        height.value = window.innerHeight;
        width.value = window.innerWidth;
    };

    onMounted(() => {
        window.addEventListener("resize", handleResize);
    });

    onUnmounted(() => {
        window.removeEventListener("resize", handleResize);
    });

    return { height, width, isMobile };
}
