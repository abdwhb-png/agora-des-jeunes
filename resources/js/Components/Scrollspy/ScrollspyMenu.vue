<template>
    <div v-for="(item, index) in elements" :key="item.target">
        <div
            v-if="item.children"
            class="flex flex-col"
            data-scrollspy-group="true"
        >
            <div
                class="ps-6 pe-2.5 py-2.5 text-2sm font-semibold text-gray-900"
            >
                {{ item.title }}
            </div>
            <div class="flex flex-col">
                <template
                    v-for="(child, childIndex) in item.children"
                    :key="child.target"
                >
                    <ScrollspyItem
                        @click="setActive(child.target)"
                        :item="child"
                    />
                </template>
            </div>
        </div>
        <ScrollspyItem v-else :item="item" @click="setActive(item.target)" />
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { IScrollspyMenuItem } from "@/types";
import ScrollspyItem from "./ScrollspyItem.vue";

export default defineComponent({
    name: "ScrollspyMenu",
    components: { ScrollspyItem },
    props: {
        items: {
            type: Array as () => IScrollspyMenuItem[],
            required: true,
        },
    },
    setup(props) {
        const elements = ref<IScrollspyMenuItem[]>(props.items);

        const setActive = (target: string) => {
            elements.value = elements.value.map((i) => ({
                ...i,
                active: i.target === target, // Vérifie si l'élément principal est cliqué
                children: i.children
                    ? i.children.map((c) => ({
                          ...c,
                          active: c.target === target, // Vérifie si un sous-élément est cliqué
                      }))
                    : undefined,
            }));
        };

        return { elements, setActive };
    },
});
</script>
