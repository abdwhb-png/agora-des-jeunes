<template>
    <nav
        class="lg:max-w-[550px] xl:max-w-[650px] mx-auto rounded-t-xl fixed bottom-0 left-0 right-0"
    >
        <div
            class="flex items-center justify-around max-h-20 px-2 pt-3 max-w-lg mx-auto"
        >
            <component
                :is="nav.route ? Link : 'a'"
                v-for="nav in navs"
                :key="nav.name"
                :href="
                    nav.route
                        ? route($page.props.routePrefix + nav.route)
                        : 'javascript:void(0)'
                "
                @click="nav.action ? nav.action() : ''"
                class="nav-item"
                :class="{ active: nav.route && route().current(nav.route) }"
            >
                <div class="nav-content">
                    <component :is="nav.icon" class="w-6 h-6" />
                    <span class="text-xs font-medium">{{ nav.name }}</span>
                </div>
            </component>
        </div>
    </nav>
    <Dialog
        v-model:visible="visible"
        modal
        :breakpoints="{ '960px': '75vw' }"
        :style="{ width: '50rem' }"
    >
        <AiChat @close="visible = false" />
    </Dialog>
</template>

<script setup>
import { ref, markRaw } from "vue";
import { Link } from "@inertiajs/vue3";
import {
    Bot,
    Bookmark,
    Ticket,
    Wallet,
    User,
    LayoutGrid,
} from "lucide-vue-next";
import AiChat from "@/Components/Examples/AiChat.vue";

const visible = ref(false);

const navs = [
    {
        name: "Commencer",
        icon: markRaw(LayoutGrid),
        route: "dashboard",
    },
    {
        name: "Favoris",
        icon: markRaw(Bookmark),
        route: "",
    },
    {
        name: "IA",
        icon: markRaw(Bot),
        action: () => (visible.value = true),
    },
    {
        name: "Wallet",
        icon: markRaw(Wallet),
        route: "",
    },
    {
        name: "Compte",
        icon: markRaw(User),
        route: "account",
    },
];
</script>

<style scoped>
nav {
    /* Remove the existing box-shadow */
    box-shadow: none;
    @apply bg-white dark:bg-gray-100 backdrop-blur-lg border-t border-tertiary-500/50 dark:border-tertiary-400/50 z-50;
}

/* Add a pseudo-element for the gradient shadow effect */
nav::after {
    content: "";
    position: absolute;
    top: -10px;
    left: 0;
    right: 0;
    height: 10px;
    @apply bg-gradient-to-r from-secondary-500 to-tertiary-600 transition-all duration-500;
    filter: blur(17px);
    opacity: 0.6;
    z-index: -1;
}

.dark nav {
    box-shadow: none;
}

.dark nav::after {
    /* Same gradient for dark mode, adjust opacity if needed */
    @apply bg-gradient-to-r from-secondary-500 to-tertiary-600 transition-all duration-500;
    opacity: 0.7;
}

.nav-item {
    @apply relative flex-1 flex items-center justify-center py-2 px-1 text-gray-500 dark:text-gray-600 transition-all duration-200;
}

.nav-content {
    @apply flex flex-col items-center space-y-1 relative;
}

.nav-item::before {
    content: "";
    @apply absolute top-0 left-1/2 -translate-x-1/2 w-0 h-1 bg-secondary-600 dark:bg-secondary-400 rounded-full transition-all duration-200;
}

.nav-item.active {
    @apply text-secondary-600 dark:text-secondary-400;
}

.nav-item.active::before {
    @apply w-8;
}

.nav-item:hover {
    @apply text-secondary-500 dark:text-secondary-400;
    transform: translateY(-2px);
}

.nav-item:active {
    transform: translateY(0px);
}

/* Animation pour l'indicateur actif */
.nav-item.active .nav-content {
    animation: bounce 0.3s ease;
}

@keyframes bounce {
    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-4px);
    }
}
</style>
