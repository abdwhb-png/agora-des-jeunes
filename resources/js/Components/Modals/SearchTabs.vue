<script setup lang="ts">
import { ModalTab } from "@/types";

defineProps({
    tabs: Object as () => ModalTab[],
});

const tabTarget = (title: string, index: number) => {
    return `${title.toLowerCase().replace(" ", "_")}_modal_tab_${index}`;
};
</script>

<template>
    <div class="tabs justify-between px-5 mb-2.5" data-tabs="true">
        <div class="flex items-center gap-5">
            <button
                v-for="(tab, index) in tabs"
                :key="index"
                class="tab py-5 active"
                :data-tab-toggle="'#' + tabTarget(tab.title, index)"
            >
                {{ tab.title }}
            </button>
        </div>
        <div class="menu -mt-px" data-menu="true">
            <div
                class="menu-item menu-item-dropdown"
                data-menu-item-offset="0, 10px"
                data-menu-item-placement="bottom-end"
                data-menu-item-placement-rtl="bottom-start"
                data-menu-item-toggle="dropdown"
                data-menu-item-trigger="click|lg:hover"
            >
                <button
                    class="menu-toggle btn btn-sm btn-icon btn-light btn-clear"
                >
                    <i class="ki-filled ki-setting-2"> </i>
                </button>
                <div
                    class="menu-dropdown menu-default w-full max-w-[175px]"
                    data-menu-dismiss="true"
                >
                    <div class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="menu-icon">
                                <i class="ki-filled ki-document"> </i>
                            </span>
                            <span class="menu-title"> View </span>
                        </a>
                    </div>
                    <div
                        class="menu-item menu-item-dropdown"
                        data-menu-item-offset="-15px, 0"
                        data-menu-item-placement="right-start"
                        data-menu-item-toggle="dropdown"
                        data-menu-item-trigger="click|lg:hover"
                    >
                        <div class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-filled ki-notification-status">
                                </i>
                            </span>
                            <span class="menu-title"> Export </span>
                            <span class="menu-arrow">
                                <i
                                    class="ki-filled ki-right text-3xs rtl:transform rtl:rotate-180"
                                >
                                </i>
                            </span>
                        </div>
                        <div
                            class="menu-dropdown menu-default w-full max-w-[175px]"
                        >
                            <div class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-sms"> </i>
                                    </span>
                                    <span class="menu-title"> Email </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="menu-icon">
                                        <i class="ki-filled ki-message-notify">
                                        </i>
                                    </span>
                                    <span class="menu-title"> SMS </span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="menu-icon">
                                        <i
                                            class="ki-filled ki-notification-status"
                                        >
                                        </i>
                                    </span>
                                    <span class="menu-title"> Push </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="scrollable-y-auto"
        data-scrollable="true"
        data-scrollable-max-height="auto"
        data-scrollable-offset="300px"
        style="max-height: 266px"
    >
        <div
            v-for="(tab, index) in tabs"
            :key="tabTarget(tab.title, index)"
            :id="tabTarget(tab.title, index)"
            class=""
        >
            <component :is="tab.content" v-bind="tab.props"></component>
        </div>
    </div>
</template>
