<script setup lang="ts">
import { computed, onMounted } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { useSidebarStore } from "@/stores/sidebar";
import { useBreadcrumbStore } from "@/stores/breadcrumb";

defineProps({
    title: String,
});

const page = usePage();

const sidebarStore = useSidebarStore();

const breadcrumbStore = useBreadcrumbStore();
const currentRoute = route().current();

const breadcrumbs = computed(() =>
    breadcrumbStore.generateBreadcrumb(sidebarStore),
);

const breadcrumbClass = (index: number, length: number) => ({
    "text-gray-700 cursor-default": index >= length - 1,
    "text-gray-900 hover:text-primary": index < length - 1,
});

onMounted(() => {
    router.on("finish", (event) => {
        if ((page.props.auth as any)?.user) {
            breadcrumbStore.updateBreadcrumb();
        }
    });
});
</script>

<template>
    <div
        class="flex flex-col md:flex-row items-center justify-center md:justify-between flex-wrap gap-1 lg:gap-5"
    >
        <h1 class="font-medium text-base text-gray-900">
            <button
                class="border rounded-lg px-2 btn-light"
                onclick="refreshPage()"
            >
                <i class="pi pi-refresh"></i>
            </button>
            {{ title || "Titre de page" }}
        </h1>
        <div class="flex items-center flex-wrap gap-1 text-sm">
            <a
                class="text-gray-900 hover:text-primary"
                href="javascript:void(0)"
                @click.prevent="sidebarStore.setSelected(0, 0)"
            >
                Accueil
            </a>
            <template v-for="(crumb, index) in breadcrumbs" :key="crumb.name">
                <span class="text-gray-400 text-sm"> / </span>
                <Link
                    v-if="crumb.route"
                    :class="breadcrumbClass(index, breadcrumbs.length)"
                    :href="route(crumb.route)"
                >
                    {{ crumb.name }}
                </Link>
                <a
                    v-else
                    :class="breadcrumbClass(index, breadcrumbs.length)"
                    href="javascript:void(0)"
                    @click.prevent="
                        sidebarStore.setSelected(crumb.menu?.title, crumb.name)
                    "
                >
                    {{ crumb.name }}
                </a>
            </template>
        </div>
    </div>
</template>
