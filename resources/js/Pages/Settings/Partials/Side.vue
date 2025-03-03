<template>
    <div :class="`w-[230px] fixed z-10 start-auto ${stickyClass}`">
        <Scrollspy
            offset="80px|lg:300px"
            class="flex flex-col grow relative before:absolute before:start-[11px] before:top-0 before:bottom-0 before:border-s before:border-gray-200"
            :items="menuItems"
        />
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { usePage } from "@inertiajs/vue3";
import { stickySidebarClasses } from "@/config/metronic-layout";
import Scrollspy from "@/Components/Scrollspy/ScrollspyIndex.vue";
import { IScrollspyMenuItem } from "@/types";

export default defineComponent({
    name: "App",
    components: {
        Scrollspy,
    },
    setup() {
        const page = usePage();

        const stickyClass = page.props.routePrefix
            ? stickySidebarClasses[page.props.routePrefix] ||
              "top-[calc(var(--tw-header-height)+1rem)]"
            : "top-[calc(var(--tw-header-height)+1rem)]";

        return {
            stickyClass,
        };
    },
    data() {
        return {
            menuItems: [
                {
                    title: "Authentification",
                    target: "#auth_settings",
                },
                {
                    title: "Sécurité",
                    target: "#security",
                    children: [
                        {
                            title: "Paramètres du compte",
                            target: "#account_settings",
                        },
                    ],
                },
                {
                    title: "Désactivation",
                    target: "#delete_account",
                },
            ] as IScrollspyMenuItem[],
        };
    },
    methods: {
        handleUpdate(id: string) {
            console.log("Active section:", id);
        },
    },
});
</script>
