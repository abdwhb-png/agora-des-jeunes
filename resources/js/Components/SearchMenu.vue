<script setup lang="ts">
import { ref, computed } from "vue";
import { useMainStore } from "@/stores/main";
import { useSidebarStore } from "@/stores/sidebar";
import { Menu } from "@/types/sidebar";

const mainStore = useMainStore();
const sidebarStore = useSidebarStore();

const results = computed(() => {
    return sidebarStore.getMenus(mainStore.mainSearch);
});
</script>
<template>
    <div class="flex flex-col gap-2.5">
        <div>
            <div class="text-xs text-gray-600 font-medium pt-2.5 pb-1.5 ps-5">
                Elements du menu
            </div>
            <div class="menu menu-default p-0 flex-col">
                <template v-for="(menu, index) in results" :key="index">
                    <div class="menu-item">
                        <a
                            class="menu-link"
                            href="#"
                            data-modal-dismiss="true"
                            @click="sidebarStore.setSelected(menu.title, 0)"
                        >
                            <span class="menu-icon">
                                <i class="ki-filled" :class="menu.icon"> </i>
                            </span>
                            <span class="menu-title">
                                {{ menu.title }}
                            </span>
                        </a>
                    </div>
                    <template v-if="menu.items">
                        <div
                            v-for="(item, itemIndex) in menu.items"
                            :key="index"
                            class="menu-item ml-4"
                        >
                            <a
                                class="menu-link"
                                href="#"
                                data-modal-dismiss="true"
                                @click="
                                    sidebarStore.setSelected(
                                        item.name,
                                        itemIndex,
                                    )
                                "
                            >
                                <span class="menu-icon">
                                    <i class="ki-filled" :class="item.icon">
                                    </i>
                                </span>
                                <span class="menu-title">
                                    {{ item.name }}
                                </span>
                            </a>
                        </div>
                    </template>
                </template>
            </div>
        </div>
    </div>
</template>
