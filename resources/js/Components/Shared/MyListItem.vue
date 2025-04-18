<script setup>
/**
 * MyListItem component
 *
 * A versatile list item component that can be used in various contexts.
 * It supports an icon, title, description, and actions.
 * It also supports different visual styles via the `variant` prop.
 */

import { computed, ref } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    // The title of the list item
    title: {
        type: String,
        required: true,
    },
    // The description of the list item (optional)
    description: {
        type: String,
        default: "",
    },
    // Max height for description before applying fade effect (in pixels)
    maxDescriptionHeight: {
        type: Number,
        default: 80,
    },
    // Max characters before applying fade effect
    maxDescriptionChars: {
        type: Number,
        default: 250,
    },
    // Icon class or name (optional)
    icon: {
        type: String,
        default: "",
    },
    // URL to navigate to when clicked (optional)
    url: {
        type: String,
        default: null,
    },
    // Route name to navigate to when clicked (optional)
    route: {
        type: String,
        default: null,
    },
    // Route params for the route (optional)
    routeParams: {
        type: Object,
        default: () => ({}),
    },
    // Visual variant: 'default', 'card', 'compact', 'bordered'
    variant: {
        type: String,
        default: "default",
        validator: (value) =>
            ["default", "card", "compact", "bordered"].includes(value),
    },
    // Whether the item is active (selected)
    active: {
        type: Boolean,
        default: false,
    },
    // Whether to open the link in a new tab
    external: {
        type: Boolean,
        default: false,
    },
    // Whether to show hover effect
    hover: {
        type: Boolean,
        default: true,
    },
    // Custom classes to apply to the component
    customClasses: {
        type: String,
        default: "",
    },
});

// Compute the classes for the list item based on the variant
const itemClasses = computed(() => {
    const baseClasses = "flex items-center gap-3";
    const hoverClasses = props.hover ? "hover:shadow transition-colors" : "";

    const variantClasses = {
        default: "p-4 rounded-lg",
        card: "p-5 rounded-lg border with-border",
        compact: "py-2 px-3",
        bordered: "p-4 border-b border-gray-300",
    };

    const activeClass = props.active
        ? "bg-secondary-active text-primary-active font-medium"
        : "with-border";

    return `${baseClasses} ${variantClasses[props.variant]} ${hoverClasses} ${activeClass} ${props.customClasses}`;
});

// Determine if we should use a Link component or an anchor tag
const isInternalLink = computed(() => {
    return props.route && !props.external;
});

// Determine if we have a link (either URL or route)
const hasLink = computed(() => {
    return props.url || props.route;
});

// Description handling
const descriptionRef = ref(null);
const shouldApplyFadeEffect = computed(() => {
    return (
        props.description &&
        props.description.length > props.maxDescriptionChars
    );
});

// Truncated description
const truncatedDescription = computed(() => {
    if (shouldApplyFadeEffect.value) {
        return (
            props.description.substring(0, props.maxDescriptionChars) + "..."
        );
    }
    return props.description;
});

// Style for the fade effect container
const descriptionContainerStyle = computed(() => {
    return {
        maxHeight: `${props.maxDescriptionHeight}px`,
        position: "relative",
    };
});
</script>

<template>
    <component
        :is="isInternalLink ? Link : hasLink ? 'a' : 'div'"
        :href="url || (route ? route(route, routeParams) : null)"
        :target="external ? '_blank' : null"
        :class="itemClasses"
    >
        <!-- Icon -->
        <div v-if="icon" class="flex-shrink-0">
            <div
                class="size-10 flex items-center justify-center rounded-full bg-gray-100"
            >
                <i :class="[icon, 'text-gray-600 text-xl']"></i>
            </div>
        </div>
        <!-- Content slot allows for custom content -->
        <slot name="icon"></slot>
        <!-- Main content -->
        <div class="flex flex-col flex-grow">
            <div class="text-sm font-medium text-gray-900">{{ title }}</div>

            <!-- Description with fade effect when too long -->
            <div
                v-if="description"
                :style="shouldApplyFadeEffect ? descriptionContainerStyle : {}"
                class="relative"
            >
                <div ref="descriptionRef" class="text-xs text-gray-600">
                    {{ truncatedDescription }}
                </div>
                <!-- Gradient fade effect overlay -->
                <div
                    v-if="shouldApplyFadeEffect"
                    class="absolute bottom-0 left-0 right-0 h-12 from-gray-100 bg-gradient-to-t dark:from-gray-100 to-transparent pointer-events-none"
                ></div>
            </div>

            <slot></slot>
        </div>

        <!-- Actions -->
        <slot name="actions"></slot>
    </component>
</template>
