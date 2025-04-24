<script setup>
import { computed } from "vue";
import { marked } from "marked";
import DOMPurify from "dompurify";

const props = defineProps({
    markdown: {
        type: String,
        required: true,
        default: "",
    },
});

const sanitizedHtml = computed(() => {
    if (!props.markdown) return "";
    const rawHtml = marked.parse(props.markdown);
    return DOMPurify.sanitize(rawHtml);
});
</script>

<template>
    <div class="markdown-preview" v-html="sanitizedHtml"></div>
</template>

<style>
.markdown-preview h1 {
    font-size: 1.8rem;
    font-weight: bold;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.markdown-preview h2 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.markdown-preview h3 {
    font-size: 1.25rem;
    font-weight: bold;
    margin-top: 1.25rem;
    margin-bottom: 0.75rem;
}

.markdown-preview p {
    margin-bottom: 1rem;
}

.markdown-preview ul,
.markdown-preview ol {
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.markdown-preview ul {
    list-style-type: disc;
}

.markdown-preview ol {
    list-style-type: decimal;
}

.markdown-preview blockquote {
    border-left: 4px solid #e5e7eb;
    padding-left: 1rem;
    margin-left: 0;
    margin-right: 0;
    font-style: italic;
    color: #6b7280;
}

.markdown-preview pre {
    background-color: #f3f4f6;
    padding: 1rem;
    border-radius: 0.375rem;
    overflow: auto;
    margin-bottom: 1rem;
}

.markdown-preview code {
    font-family:
        ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas,
        "Liberation Mono", "Courier New", monospace;
    font-size: 0.875em;
    background-color: #f3f4f6;
    padding: 0.25rem 0.375rem;
    border-radius: 0.25rem;
}

.markdown-preview pre code {
    padding: 0;
    background-color: transparent;
}

.markdown-preview a {
    color: #2563eb;
    text-decoration: underline;
}

.markdown-preview a:hover {
    text-decoration: none;
}

.markdown-preview img {
    max-width: 100%;
    height: auto;
}

.markdown-preview table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 1rem;
}

.markdown-preview table th,
.markdown-preview table td {
    border: 1px solid #e5e7eb;
    padding: 0.5rem;
}

.markdown-preview table th {
    background-color: #f9fafb;
    font-weight: bold;
}
</style>
