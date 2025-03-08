<script setup>
import { onMounted, ref, watch, nextTick } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import DropdownSearch from "@/Components/Base/DropdownSearch.vue";

const props = defineProps({
    dataCount: {
        type: String,
        default: "",
    },
    searchKey: String,
    tabKey: String,
});

const page = usePage();
const searchInput = ref(page.props.filters[props.searchKey]);

const tabs = ref();

onMounted(() => {
    nextTick(() => {
        const options = {
            hiddenClass: "hidden",
        };
        if (tabs.value) {
            new KTTabs(tabs.value, options);
        }
    });
});

watch(searchInput, (value) => {
    router.get(
        route().current(),
        { [props.searchKey]: value },
        { preserveState: true },
    );
});
</script>

<template>
    <div class="flex flex-wrap items-center gap-5 justify-center">
        <h3 class="text-lg text-gray-900 font-semibold">{{ dataCount }}</h3>
        <div class="flex justify-between gap-5">
            <div class="btn-tabs" data-tabs="false" ref="tabs">
                <button
                    class="btn btn-icon active"
                    :data-tab-toggle="`#${tabKey}_cards`"
                    type="button"
                >
                    <i class="ki-filled ki-category"> </i>
                </button>
                <button
                    class="btn btn-icon"
                    :data-tab-toggle="`#${tabKey}_list`"
                    type="button"
                >
                    <i class="ki-filled ki-row-horizontal"> </i>
                </button>
            </div>
            <slot name="newBtn"></slot>
            <DropdownSearch v-model="searchInput" @reset="searchInput = null" />
        </div>
    </div>
</template>
