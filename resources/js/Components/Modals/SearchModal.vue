<script setup lang="ts">
import { ModalTab } from "@/types";
import { useMainStore } from "@/stores/main";
import SearchTabs from "./SearchTabs.vue";
import SearchMenu from "../SearchMenu.vue";
import { markRaw } from "vue";

const mainStore = useMainStore();

const tabs: ModalTab[] = [
    {
        title: "Menu",
        content: markRaw(SearchMenu),
    },
];
</script>

<template>
    <div class="modal" data-modal="true" id="search_modal">
        <div class="modal-content max-w-[600px] top-[15%]">
            <div class="modal-header py-4 px-5">
                <i class="ki-filled ki-magnifier text-gray-700 text-xl"> </i>
                <input
                    class="input px-0 border-none bg-transparent shadow-none ms-2.5"
                    name="query"
                    v-model="mainStore.mainSearch"
                    placeholder="Tape pour rechercher"
                    type="text"
                />
                <button
                    class="btn btn-sm btn-icon btn-light btn-clear shrink-0"
                    data-modal-dismiss="true"
                    @click="mainStore.mainSearch = ''"
                >
                    <i class="ki-filled ki-cross"> </i>
                </button>
            </div>
            <div class="modal-body p-0 pb-5">
                <SearchTabs :tabs="tabs" />
            </div>
        </div>
    </div>
</template>
