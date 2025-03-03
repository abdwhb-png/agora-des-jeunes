<script setup>
import { useMainStore } from "@/stores/main";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    footerLinks: {
        type: Array,
        default: [
            {
                label: "Faqs",
                route: "faqs",
            },
        ],
    },
});

const page = usePage();
const mainStore = useMainStore();

const links = [...mainStore.menuItems, ...props.footerLinks];
</script>

<template>
    <footer class="footer">
        <!-- Container -->
        <div class="container-fluid">
            <div
                class="flex flex-col md:flex-row justify-center md:justify-between items-center gap-3 py-5"
            >
                <div class="flex order-2 md:order-1 gap-2 font-normal text-2sm">
                    <span class="text-gray-500">
                        {{ new Date().getFullYear() }} &copy;
                    </span>
                    <span class="hidden md:block">Tous droits réservés. </span>
                    <a
                        class="text-gray-600 hover:text-primary underline"
                        :href="page.props.app.frontend_url || ''"
                    >
                        {{ $page.props.app.name }}
                    </a>
                </div>
                <nav
                    class="flex order-1 md:order-2 gap-4 font-normal text-xs text-gray-600"
                >
                    <a
                        v-for="(link, index) in links"
                        :key="index"
                        class="hover:text-primary"
                        :href="link.route ? route(link.route) : link.href"
                    >
                        {{ link.label }}
                    </a>
                </nav>
            </div>
        </div>
        <!-- End of Container -->
    </footer>
</template>
