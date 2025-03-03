<script setup>
import BottomCta from "@/Components/Home/BottomCta.vue";
import Footer from "@/Components/Home/Footer.vue";
import HeaderNav from "@/Components/Home/HeaderNav.vue";
import Toaster from "@/Components/ui/toast/Toaster.vue";
import { onMounted, nextTick } from "vue";

defineProps({
    title: String,
    errorStatus: {
        type: String | Number,
        default: null,
    },
});

const scripts = [
    "/cdn.prod.website-files.com/67590e9b756ef477159ae9e4/js/webflow.9be093c2.c582a7df1a15d31e.js",
];

onMounted(() => {
    scripts.forEach((script, index) => {
        const id = "home-script_" + index;
        const existent = document.getElementById(id);
        if (!existent) {
            const s = document.createElement("script");
            s.src = script;
            s.id = id;
            document.body.appendChild(s);
        }
    });
    nextTick(() => {});
});
</script>

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
