<script setup lang="ts">
import { ref, computed } from "vue";
import MarkdownPreview from "@/Components/Base/MarkdownPreview.vue";

interface ProjectProps {
    title: string;
    description: string;
    markdown_content?: string;
    html_content?: string;
    created_at?: string;
    updated_at?: string;
    owner?: {
        name: string;
        avatar?: string;
    };
}

const props = defineProps<ProjectProps>();

const activeTab = ref<"markdown" | "html">("markdown");

const hasContent = computed(() => {
    return Boolean(props.markdown_content || props.html_content);
});

const formattedDate = computed(() => {
    if (!props.created_at) return "";

    const date = new Date(props.created_at);
    return new Intl.DateTimeFormat("fr-FR", {
        day: "numeric",
        month: "long",
        year: "numeric",
    }).format(date);
});
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">{{ title }}</h2>

                <div v-if="owner" class="flex items-center">
                    <div
                        v-if="owner.avatar"
                        class="h-10 w-10 rounded-full overflow-hidden mr-3"
                    >
                        <img
                            :src="owner.avatar"
                            :alt="owner.name"
                            class="h-full w-full object-cover"
                        />
                    </div>
                    <div
                        v-else
                        class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center mr-3"
                    >
                        <span class="text-primary-700 font-medium text-sm">{{
                            owner.name.substring(0, 2).toUpperCase()
                        }}</span>
                    </div>
                    <span class="text-sm text-gray-600">{{ owner.name }}</span>
                </div>
            </div>

            <div class="mt-2 text-gray-600">
                <p>{{ description }}</p>
            </div>

            <div v-if="created_at" class="mt-4 text-xs text-gray-500">
                Créé le {{ formattedDate }}
            </div>
        </div>

        <!-- Content -->
        <div v-if="hasContent" class="p-6">
            <!-- Tabs -->
            <div
                v-if="markdown_content && html_content"
                class="flex border-b border-gray-200 mb-4"
            >
                <button
                    @click="activeTab = 'markdown'"
                    class="px-4 py-2 text-sm font-medium mr-2"
                    :class="[
                        activeTab === 'markdown'
                            ? 'text-primary-600 border-b-2 border-primary-600'
                            : 'text-gray-500 hover:text-gray-700 hover:border-gray-300',
                    ]"
                >
                    Markdown
                </button>
                <button
                    @click="activeTab = 'html'"
                    class="px-4 py-2 text-sm font-medium"
                    :class="[
                        activeTab === 'html'
                            ? 'text-primary-600 border-b-2 border-primary-600'
                            : 'text-gray-500 hover:text-gray-700 hover:border-gray-300',
                    ]"
                >
                    HTML
                </button>
            </div>

            <!-- Content display -->
            <div class="prose max-w-none">
                <MarkdownPreview
                    v-if="markdown_content && activeTab === 'markdown'"
                    :markdown="markdown_content"
                />

                <div
                    v-else-if="html_content && activeTab === 'html'"
                    v-html="html_content"
                    class="rendered-html"
                ></div>

                <MarkdownPreview
                    v-else-if="markdown_content"
                    :markdown="markdown_content"
                />

                <div
                    v-else-if="html_content"
                    v-html="html_content"
                    class="rendered-html"
                ></div>
            </div>
        </div>

        <!-- No content message -->
        <div v-else class="p-6 text-center text-gray-500 italic">
            Aucun contenu disponible pour ce projet.
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 flex justify-end">
            <slot name="actions">
                <button
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    Éditer
                </button>
                <button
                    class="ml-3 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    Voir plus
                </button>
            </slot>
        </div>
    </div>
</template>

<style scoped>
.rendered-html :deep(h1) {
    font-size: 1.8rem;
    font-weight: bold;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.rendered-html :deep(h2) {
    font-size: 1.5rem;
    font-weight: bold;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.rendered-html :deep(h3) {
    font-size: 1.25rem;
    font-weight: bold;
    margin-top: 1.25rem;
    margin-bottom: 0.75rem;
}

.rendered-html :deep(p) {
    margin-bottom: 1rem;
}

.rendered-html :deep(ul),
.rendered-html :deep(ol) {
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.rendered-html :deep(ul) {
    list-style-type: disc;
}

.rendered-html :deep(ol) {
    list-style-type: decimal;
}

.rendered-html :deep(blockquote) {
    border-left: 4px solid #e5e7eb;
    padding-left: 1rem;
    margin-left: 0;
    margin-right: 0;
    font-style: italic;
    color: #6b7280;
}

.rendered-html :deep(pre) {
    background-color: #f3f4f6;
    padding: 1rem;
    border-radius: 0.375rem;
    overflow: auto;
    margin-bottom: 1rem;
}

.rendered-html :deep(code) {
    font-family:
        ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas,
        "Liberation Mono", "Courier New", monospace;
    font-size: 0.875em;
    background-color: #f3f4f6;
    padding: 0.25rem 0.375rem;
    border-radius: 0.25rem;
}

.rendered-html :deep(pre code) {
    padding: 0;
    background-color: transparent;
}

.rendered-html :deep(a) {
    color: #2563eb;
    text-decoration: underline;
}

.rendered-html :deep(a:hover) {
    text-decoration: none;
}

.rendered-html :deep(img) {
    max-width: 100%;
    height: auto;
}

.rendered-html :deep(table) {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 1rem;
}

.rendered-html :deep(table th),
.rendered-html :deep(table td) {
    border: 1px solid #e5e7eb;
    padding: 0.5rem;
}

.rendered-html :deep(table th) {
    background-color: #f9fafb;
    font-weight: bold;
}
</style>
