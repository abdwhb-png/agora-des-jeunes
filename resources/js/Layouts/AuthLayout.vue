<style>
.page-bg {
    background-image: url("/static/media/images/2600x1200/bg-3.png");
}
.dark .page-bg {
    background-image: url("/static/media/images/2600x1200/bg-3-dark.png");
}

.branded-bg {
    background-image: url("/static/media/images/2600x1600/3-min.png");
}
.dark .branded-bg {
    background-image: url("/static/media/images/2600x1600/3-min-dark.png");
}
</style>

<template>
    <div
        v-if="!branded"
        class="flex items-center justify-center grow bg-center bg-no-repeat page-bg px-2 md:px-0"
    >
        <slot />
    </div>
    <div
        v-else
        class="grid lg:grid-cols-2 grow bg-orange-50"
        :style="{
            minHeight: viewportHeight + 'px',
        }"
    >
        <div
            class="flex flex-col justify-center items-center order-2 lg:order-1"
        >
            <Message
                v-if="authStatus"
                :severity="authStatus.severity"
                :closable="true"
            >
                {{ authStatus.message }}
            </Message>
            <div
                class="flex flex-col gap-3 justify-center items-center p-8 lg:p-10"
            >
                <div>
                    <HomeBtn />
                </div>
                <slot name="form" />
            </div>
        </div>
        <div
            class="lg:rounded-xl lg:border lg:border-gray-200 lg:m-5 order-1 lg:order-2 bg-top xxl:bg-center xl:bg-cover bg-no-repeat branded-bg"
        >
            <div class="flex flex-col pb-0 sm:pb-8 p-8 lg:p-16 gap-4">
                <a href="/" class="text-center">
                    <Logo class="h-20 max-w-none relative left-[-10px]" />
                </a>
                <div class="flex flex-col gap-3">
                    <slot name="headerText">
                        <h3 class="text-2xl font-semibold text-gray-900">
                            {{ $page.props.config.seo.slogan }}
                        </h3>
                        <div class="text-base font-medium text-gray-600">
                            Retrouve ici tous les outils nécessaires
                            <br />
                            pour ton développement personnel
                            <br />
                            et ton avenir professionnel.
                        </div>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useBodyClasses } from "@/composables/useBodyClasses";
import { useViewport } from "@/composables/useViewport";
import { usePage } from "@inertiajs/vue3";
import { nextTick, onMounted } from "vue";

import Logo from "@/Components/Logo.vue";
import HomeBtn from "@/Components/HomeBtn.vue";

interface Status {
    message: string;
    severity?: string;
}

const authStatus: Status | null =
    (usePage().props.authStatus as Status) || null;

defineProps({
    branded: {
        type: Boolean,
        default: false,
    },
});

useBodyClasses("dark:bg-coal-500");

const { height: viewportHeight } = useViewport();

onMounted(() => {
    nextTick(() => {
        KTTogglePassword.init();
    });
});
</script>
