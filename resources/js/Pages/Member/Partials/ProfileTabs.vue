<script setup lang="ts">
import { User } from "@/types";

defineProps({
    user: { type: Object as () => User, required: true },
});

interface Tab {
    title: string;
    url?: string;
    component?: any;
}

const tabs: Tab[] = [
    {
        title: "Formations",
        url: "",
    },
    {
        title: "Curriculum Vitae (CV)",
        url: "",
    },
    {
        title: "Jobs",
        url: "",
    },
];
</script>

<template>
    <div
        class="flex items-center flex-wrap md:flex-nowrap lg:items-end justify-between border-b border-b-gray-200 dark:border-b-coal-100 gap-3 lg:gap-6 mb-5 lg:mb-10"
    >
        <div class="grid">
            <div class="scrollable-x-auto">
                <div class="menu gap-3" data-menu="true">
                    <div
                        v-for="(tab, index) in tabs"
                        :key="tab.title"
                        class="menu-item border-b-2 border-b-transparent menu-item-active:border-b-primary menu-item-here:border-b-primary"
                    >
                        <a class="menu-link gap-1.5 pb-2 lg:pb-4 px-2" href="#">
                            <span
                                class="menu-title text-nowrap font-medium text-sm text-gray-700 menu-item-active:text-primary menu-item-active:font-semibold menu-item-here:text-primary menu-item-here:font-semibold menu-item-show:text-primary menu-link-hover:text-primary"
                            >
                                {{ tab.title }}
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="flex items-center justify-end grow lg:grow-0 lg:pb-4 gap-2.5 mb-3 lg:mb-0"
        >
            <button class="btn btn-sm btn-primary">
                <i class="ki-filled ki-user-edit"> </i>
                Modifier
            </button>
            <div
                class="dropdown"
                data-dropdown="true"
                data-dropdown-placement="bottom-end"
                data-dropdown-placement-rtl="bottom-start"
                data-dropdown-trigger="click"
            >
                <button class="dropdown-toggle btn btn-sm btn-icon btn-light">
                    <i class="ki-filled ki-dots-vertical"> </i>
                </button>
                <div
                    class="dropdown-content menu-default w-full max-w-[220px] hidden"
                    style="opacity: 0"
                >
                    <div class="menu-item" data-dropdown-dismiss="true">
                        <button
                            class="menu-link"
                            data-modal-toggle="#share_profile_modal"
                        >
                            <span class="menu-icon">
                                <i class="ki-filled ki-coffee"> </i>
                            </span>
                            <span class="menu-title"> Share Profile </span>
                        </button>
                    </div>
                    <div class="menu-item" data-dropdown-dismiss="true">
                        <a
                            class="menu-link"
                            data-modal-toggle="#give_award_modal"
                            href="#"
                        >
                            <span class="menu-icon">
                                <i class="ki-filled ki-award"> </i>
                            </span>
                            <span class="menu-title"> Give Award </span>
                        </a>
                    </div>
                    <div class="menu-item" data-dropdown-dismiss="true">
                        <button class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-filled ki-chart-line"> </i>
                            </span>
                            <span class="menu-title"> Stay Updated </span>
                            <label class="switch switch-sm">
                                <input name="check" type="checkbox" value="1" />
                            </label>
                        </button>
                    </div>
                    <div class="menu-item" data-dropdown-dismiss="true">
                        <button
                            class="menu-link"
                            data-modal-toggle="#report_user_modal"
                        >
                            <span class="menu-icon">
                                <i class="ki-filled ki-information-2"> </i>
                            </span>
                            <span class="menu-title"> Report User </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
