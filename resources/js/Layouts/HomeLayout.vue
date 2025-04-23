<template>
    <Head :title="meta?.title || title" />

    <div class="page-wrapper">
        <HeaderNav v-if="!errorStatus" />

        <slot name="header"></slot>

        <main class="main-wrapper">
            <slot></slot>

            <slot name="footer">
                <BottomCta v-if="!errorStatus" />
            </slot>
        </main>

        <Footer v-if="!errorStatus" />
    </div>

    <Toaster />
    <ScrollTop />
</template>

<script setup>
import "@css/home.css";
import BottomCta from "@/Components/Home/BottomCta.vue";
import Footer from "@/Components/Home/Footer.vue";
import HeaderNav from "@/Components/Home/HeaderNav.vue";
import Toaster from "@/Components/ui/toast/Toaster.vue";
import { onMounted, nextTick, onUnmounted, ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { useDarkModeStore } from "@/stores/darkMode";
import { loadStyles, loadScripts } from "@/utils/DomHelpers.ts";

const props = defineProps({
    title: String,
    meta: {
        type: Object,
        default: () => null,
    },
    errorStatus: {
        type: [String, Number],
        default: null,
    },
});

const page = usePage();
const { isDark, toggleDarkMode } = useDarkModeStore();
const pathName = ref();

const styles = [
    // "https://cdn.jsdelivr.net/npm/daisyui@4.12.24/dist/full.min.css",
    "/cdn.prod.website-files.com/67590e9b756ef477159ae9e4/css/notefye.webflow.cd2157501.css",
];
const scripts = [
    // "/d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c887ab.js?site=67590e9b756ef477159ae9e4",
    "/cdn.prod.website-files.com/67590e9b756ef477159ae9e4/js/webflow.9be093c2.c582a7df1a15d31e.js",
];

onMounted(() => {
    loadMeta();
    if (!page.url.includes(page.props.fortifyPrefix)) {
        loadStyles(styles, "home-styles");
        loadScripts(scripts, "home-scripts");
    }

    if (isDark) {
        toggleDarkMode();
    }

    router.on("start", (event) => {
        pathName.value = event.detail.visit.url.pathname;
    });

    nextTick(() => {
        document.querySelector("html").setAttribute("data-theme", "light");

        document.querySelectorAll(".set-animation").forEach((el) => {
            // Créer un observateur pour surveiller la visibilité de l'élément
            const observer = new IntersectionObserver(
                ([entry]) => {
                    if (entry.isIntersecting) {
                        el.classList.add("animate__animated");
                        const animation = {
                            name:
                                el.getAttribute("data-animation") ||
                                "animate__bounceIn",
                            duration: el.getAttribute("data-duration") || 1000,
                            delay: el.getAttribute("data-delay") || 0,
                            noRepeat:
                                el.getAttribute("data-no-repeat") === "true",
                        };

                        el.classList.add(animation.name); // Ajoute l'animation

                        if (animation.noRepeat) {
                            observer.unobserve(el); // Désactive l'observation après une seule exécution
                        } else {
                            setTimeout(() => {
                                el.classList.remove(animation.name); // Remove the animation class
                            }, animation.duration); // Durée ajustable selon l'animation
                        }
                    }
                },
                { threshold: 0.5 }, // Déclenche l'animation lorsque 50% de l'élément est visible
            );

            observer.observe(el);
        });
    });
});

onUnmounted(() => {
    loadStyles(styles, "home-styles", true);
    loadScripts(scripts, "home-scripts", true);
});

function loadMeta() {
    if (props.meta) {
        for (const [name, content] of Object.entries(props.meta)) {
            document.head
                .querySelector(`meta[name="${name}"]`)
                ?.setAttribute("content", content);
        }
    }
}
</script>
