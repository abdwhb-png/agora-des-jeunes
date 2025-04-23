<template>
    <div>
        <!-- Search Trigger Button -->
        <button
            @click="openSearchModal"
            class="flex items-center justify-center p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
            aria-label="Search"
        >
            <slot name="icon">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    />
                </svg>
            </slot>
        </button>
        <!-- Search Modal - Restructured for proper event bubbling -->
        <div
            v-if="isModalOpen"
            class="fixed inset-0 z-50"
            @keydown.esc="closeSearchModal"
        >
            <!-- Backdrop with blur effect -->
            <div
                class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity"
                @click="closeSearchModal"
            ></div>

            <!-- Modal Content Wrapper -->
            <div class="fixed inset-0 overflow-y-auto pointer-events-none">
                <div
                    class="flex items-start justify-center min-h-screen pt-16 px-4 pb-20 text-center sm:block sm:p-0"
                >
                    <div
                        class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full pointer-events-auto"
                    >
                        <!-- Search Input Section -->
                        <div
                            class="border-b border-gray-200 dark:border-gray-700"
                        >
                            <div class="flex items-center px-4 py-3">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                                <input
                                    ref="searchInput"
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Recherche ou demande..."
                                    class="w-full px-3 py-2 bg-transparent border-none focus:outline-none focus:ring-0 text-gray-900 dark:text-white"
                                    @input="handleSearchInput"
                                />
                                <div
                                    @click="closeSearchModal"
                                    class="text-xs text-gray-500 dark:text-gray-400 cursor-pointer"
                                >
                                    ESC
                                </div>
                            </div>
                        </div>

                        <!-- Search Results Section -->
                        <div class="max-h-[60vh] overflow-y-auto">
                            <div v-if="searchQuery.length > 0" class="p-4">
                                <!-- Ask AI (always first) -->
                                <div
                                    class="flex items-center p-3 mb-4 bg-gray-100 dark:bg-gray-700 border border-secondary-500 dark:border-secondary-400 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                                    @click="isAiMode = true"
                                >
                                    <div class="mr-3 mt-1">
                                        <Bot
                                            class="text-tertiary-500 dark:text-tertiary-400"
                                            :size="25"
                                        />
                                    </div>
                                    <div class="flex-1">
                                        <div
                                            class="text-gray-900 dark:text-white"
                                        >
                                            Peux-tu me parler de
                                            <span
                                                class="font-bold text-primary"
                                                >{{ searchQuery }}</span
                                            >
                                            ?
                                        </div>
                                        <div
                                            class="text-sm text-gray-500 dark:text-gray-400 flex justify-between items-center"
                                        >
                                            <span
                                                >Utilises l'IA pour répondre à
                                                ta question</span
                                            >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 5l7 7-7 7"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <AiSearch
                                    v-if="isAiMode"
                                    :query="searchQuery"
                                    @back="isAiMode = false"
                                    @search="handleAiSearch"
                                    @close="handleClose"
                                    @feedback="handleFeedback"
                                />

                                <!-- Search Results -->
                                <div v-else class="mb-4">
                                    <div
                                        v-for="(
                                            result, index
                                        ) in filteredResults"
                                        :key="index"
                                        class="mb-4 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-md transition-colors"
                                        @click="selectResult(result)"
                                    >
                                        <div
                                            class="text-gray-900 dark:text-white font-medium"
                                        >
                                            {{ result.section }}
                                            <span
                                                v-if="result.subsection"
                                                class="text-gray-700 dark:text-gray-400 font-normal"
                                            >
                                                >
                                                {{ result.subsection }}
                                            </span>
                                        </div>
                                        <div
                                            class="text-sm text-gray-500 dark:text-gray-400"
                                            v-html="
                                                highlightSearchTerm(
                                                    result.preview,
                                                )
                                            "
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import { ref, computed, onMounted, nextTick, watch } from "vue";
import { debounce } from "lodash";
import { useSidebarStore } from "@/stores/sidebar";
import { Bot } from "lucide-vue-next";
import { useMainStore } from "@/stores/main";
import { MENU_CONFIGS } from "@/constants";
import AiSearch from "./AiSearch.vue";

const page = usePage();
const mainStore = useMainStore();
const sidebarStore = useSidebarStore();

// State
const isModalOpen = ref(false);
const isAiMode = ref(false);
const searchQuery = ref("");
const searchInput = ref<HTMLInputElement | null>(null);

const searchResults = ref([]);

// Convert the menus to searchResults format
const convertMenusToSearchResults = () => {
    const items = [...mainStore.menuItems, ...mainStore.resourceItems];
    const mainMenus = items.map((item) => ({
        section: item.label,
        subsection: null,
        preview: item.description || "",
        url: item.href ? item.href : route(item.route) || "#",
    }));

    var dashMenus = [];
    if (page.props.config.is_gestion) {
        dashMenus = Object.values(MENU_CONFIGS).map((item) => ({
            section: item.title,
            subsection: null,
            preview: item.description || "",
            url: route(page.props.routePrefix + "dashboard"),
        }));
    }

    const sidebarsMenus = sidebarStore.menus.flatMap((menu) => {
        const results = [];

        // Add the main menu item
        results.push({
            section: menu.title,
            subsection: null,
            preview: menu.description || "",
            url: "#",
            action: () => sidebarStore.setSelected(menu.title, 0),
        });

        // Add sub-items if they exist
        menu.items?.forEach((item) => {
            results.push({
                section: menu.title,
                subsection: item.name,
                preview: item.description || "",
                url: "#",
                action: () => sidebarStore.setSelected(menu.title, item.name),
            });

            item.children?.forEach((child) => {
                results.push({
                    section: menu.title,
                    subsection: child.name, // Updated to use child.name
                    preview: child.description || "", // Updated to use child.description
                    url: "#",
                    action: () =>
                        sidebarStore.setSelected(menu.title, child.name),
                });
            });
        });

        return results;
    });

    searchResults.value = [...mainMenus, ...sidebarsMenus, ...dashMenus];
};
convertMenusToSearchResults();

// Computed properties
const filteredResults = computed(() => {
    if (!searchQuery.value) return [];

    const query = searchQuery.value.toLowerCase();
    return searchResults.value.filter((result) => {
        return (
            result.section?.toLowerCase().includes(query) ||
            result.subsection?.toLowerCase().includes(query) ||
            result.preview?.toLowerCase().includes(query)
        );
    });
});

// Methods
const openSearchModal = () => {
    isModalOpen.value = true;
    searchQuery.value = "";

    // Focus the search input after the modal is rendered
    nextTick(() => {
        if (searchInput.value) {
            searchInput.value.focus();
        }
    });

    // Add event listener for ESC key
    document.addEventListener("keydown", handleEscKey);
};

const closeSearchModal = () => {
    isModalOpen.value = false;
    document.removeEventListener("keydown", handleEscKey);
};

const handleEscKey = (e: KeyboardEvent) => {
    if (e.key === "Escape") {
        closeSearchModal();
    }
};

const handleSearchInput = debounce(() => {
    // In a real implementation, this would trigger an API call to fetch search results
    // console.log("Searching for:", searchQuery.value);
}, 300);

const handleAiSearch = (query: string) => {
    isAiMode.value = false;
    searchQuery.value = query;
};

const handleFeedback = (type: "thumbsUp" | "thumbsDown" | "regenerate") => {
    // You can add any feedback handling logic here
    console.log("Feedback received:", type);
};

const handleClose = () => {
    searchQuery.value = "";
    isModalOpen.value = false;
};

const selectResult = (result: any) => {
    // console.log("Selected result:", result);
    closeSearchModal();
    if (result.action) {
        result.action();
    } else if (result.url && result.url != "#") {
        window.location.replace(result.url);
    }
};

const highlightSearchTerm = (text: string) => {
    if (!searchQuery.value) return text;

    const regex = new RegExp(`(${searchQuery.value})`, "gi");
    return text.replace(regex, '<span class="font-bold">$1</span>');
};

// Cleanup on component unmount
onMounted(() => {
    // Add global event listeners if needed
});

watch(isModalOpen, (newVal) => {
    if (newVal) {
        // Prevent body scrolling when modal is open
        document.body.style.overflow = "hidden";
    } else {
        // Restore body scrolling when modal is closed
        document.body.style.overflow = "";
    }
});
</script>

<style scoped>
/* Transitions for modal */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

/* Ensure the modal has proper z-index */
.fixed {
    z-index: 50;
}

/* Additional styling for the search results */
:deep(.prose) {
    max-width: none;
}

:deep(.prose pre) {
    margin: 1em 0;
}

:deep(.prose code) {
    color: inherit;
}
</style>
