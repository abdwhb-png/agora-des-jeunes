<style>
/* @import "@css/home.css"; */
</style>

<template>
    <Head :title="title" />

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
import { onMounted, nextTick, onUnmounted } from "vue";

defineProps({
    title: String,
    errorStatus: {
        type: [String, Number],
        default: null,
    },
});

const styles = [
    "/cdn.prod.website-files.com/67590e9b756ef477159ae9e4/css/notefye.webflow.cd2157501.css",
];
const scripts = [
    // "/d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c887ab.js?site=67590e9b756ef477159ae9e4",
    "/cdn.prod.website-files.com/67590e9b756ef477159ae9e4/js/webflow.9be093c2.c582a7df1a15d31e.js",
];

onMounted(() => {
    loadStyles(styles, "home-styles");
    loadScripts(scripts, "home-scripts");
    nextTick(() => {});
});

onUnmounted(() => {
    loadStyles(styles, "home-styles", true);
    // loadScripts(scripts, "home-scripts", true);
});
</script>
