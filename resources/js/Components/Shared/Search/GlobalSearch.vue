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
                                <!-- AI Suggestion (always first) -->
                                <div
                                    class="flex items-start p-3 mb-4 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                                    @click="activateAiMode"
                                >
                                    <div class="mr-3 mt-1">
                                        <Bot class="text-tertiary-500" />
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

                                <!-- Search Results -->
                                <div
                                    v-if="!isAiMode"
                                    class="border-t border-gray-200 dark:border-gray-700 pt-4"
                                >
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

                                <!-- AI Answer Mode -->
                                <div v-else class="mt-4">
                                    <!-- Back Button -->
                                    <div
                                        class="border border-gray-200 dark:border-gray-700 rounded-lg p-3 mb-4 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                        @click="isAiMode = false"
                                    >
                                        <div
                                            class="flex items-center text-gray-500 dark:text-gray-400"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 mr-2"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 19l-7-7 7-7"
                                                />
                                            </svg>
                                            Retour à la recherche générique...
                                        </div>
                                    </div>

                                    <!-- Original Query -->
                                    <div class="flex items-center mb-3">
                                        <div
                                            class="bg-blue-500 rounded-full p-1 mr-2"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 text-white"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </div>
                                        <div
                                            class="text-gray-900 dark:text-white"
                                        >
                                            {{ searchQuery }}
                                        </div>
                                    </div>

                                    <!-- AI Response -->
                                    <div
                                        class="text-gray-800 dark:text-gray-300 mb-4 prose dark:prose-invert max-w-none"
                                    >
                                        <div v-if="aiResponse">
                                            <h3>{{ aiResponse.title }}</h3>
                                            <p>{{ aiResponse.description }}</p>
                                            <ul>
                                                <li
                                                    v-for="(
                                                        point, i
                                                    ) in aiResponse.points"
                                                    :key="i"
                                                >
                                                    {{ point }}
                                                </li>
                                            </ul>
                                            <pre
                                                v-if="aiResponse.code"
                                                class="bg-gray-100 dark:bg-gray-700 p-3 rounded-md overflow-x-auto"
                                            ><code>{{ aiResponse.code }}</code></pre>
                                        </div>
                                        <div v-else class="text-center py-4">
                                            <div class="animate-pulse">
                                                Génération de la réponse...
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Related Topics -->
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span
                                            v-for="(tag, i) in relatedTopics"
                                            :key="i"
                                            class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-md text-sm"
                                            >{{ tag }}</span
                                        >
                                    </div>

                                    <!-- Feedback Buttons -->
                                    <div class="flex justify-end mt-3">
                                        <button
                                            class="text-gray-500 dark:text-gray-400 mx-1 hover:text-gray-700 dark:hover:text-gray-200 transition-colors"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"
                                                />
                                            </svg>
                                        </button>
                                        <button
                                            class="text-gray-500 dark:text-gray-400 mx-1 hover:text-gray-700 dark:hover:text-gray-200 transition-colors"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"
                                                />
                                            </svg>
                                        </button>
                                        <button
                                            class="text-gray-500 dark:text-gray-400 mx-1 hover:text-gray-700 dark:hover:text-gray-200 transition-colors"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"
                                                />
                                            </svg>
                                        </button>
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
import { ref, computed, onMounted, nextTick, watch } from "vue";
import { debounce } from "lodash";
import { useSidebarStore } from "@/stores/sidebar";
import { Bot } from "lucide-vue-next";
import { useMainStore } from "@/stores/main";

const mainStore = useMainStore();
const sidebarStore = useSidebarStore();

// State
const isModalOpen = ref(false);
const searchQuery = ref("");
const searchInput = ref<HTMLInputElement | null>(null);
const isAiMode = ref(false);
const aiResponse = ref<null | {
    title: string;
    description: string;
    points: string[];
    code?: string;
}>(null);

// Convert the menus to searchResults format
const searchResults = computed(() => {
    const items = [...mainStore.menuItems, ...mainStore.resourceItems];
    const mainMenus = items.map((item) => ({
        section: item.label,
        subsection: null,
        preview: item.description || "",
        url: item.href ? item.href : route(item.route) || "#",
    }));

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

    return [...mainMenus, ...sidebarsMenus];
});

const relatedTopics = ref([
    "API",
    "Documentation",
    "Search",
    "Integration",
    "Authentication",
    "Examples",
]);

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
    isAiMode.value = false;
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
    console.log("Searching for:", searchQuery.value);
}, 300);

const activateAiMode = () => {
    isAiMode.value = true;
    aiResponse.value = null;

    // Simulate AI response generation with a delay
    setTimeout(() => {
        aiResponse.value = {
            title: `Information about "${searchQuery.value}"`,
            description: `Here's what I found about "${searchQuery.value}" in our documentation:`,
            points: [
                `"${searchQuery.value}" is a key concept in our platform that helps developers build efficient applications.`,
                `You can configure "${searchQuery.value}" settings in the dashboard under Settings > Advanced.`,
                `For optimal performance, make sure to follow the best practices for "${searchQuery.value}" as outlined in our guides.`,
            ],
            code: `// Example code for ${searchQuery.value}
const client = new ApiClient({
  apiKey: 'your-api-key',
  options: {
    ${searchQuery.value}: true,
    timeout: 5000
  }
});`,
        };
    }, 1500);
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
