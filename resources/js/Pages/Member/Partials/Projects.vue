<script setup>
import ProfileCompToolbar from "./ProfileCompToolbar.vue";
import NewProject from "./NewProject.vue";

defineProps({
    projects: { type: Object, default: [] },
});
</script>

<template>
    <div class="container-fixed">
        <!-- begin: projects -->
        <div class="flex flex-col items-stretch gap-5 lg:gap-7.5">
            <!-- begin: toolbar -->
            <ProfileCompToolbar
                :data-count="projects.total + ' Projets'"
                search-key="search_project"
                tab-key="projects"
            >
                <template #newBtn>
                    <NewProject />
                </template>
            </ProfileCompToolbar>
            <!-- end: toolbar -->
            <!-- begin: cards -->
            <div id="projects_cards" class="" style="">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-7.5">
                    <div
                        v-for="(item, index) in projects.data"
                        :key="item.id || index"
                        class="card overflow-hidden grow justify-between"
                    >
                        <div class="p-5 mb-5">
                            <div class="flex items-center justify-between mb-5">
                                <span class="badge badge-primary badge-outline">
                                    {{ item.status }}
                                </span>
                                <div class="menu" data-menu="true">
                                    <div
                                        class="menu-item menu-item-dropdown"
                                        data-menu-item-offset="0, 10px"
                                        data-menu-item-placement="bottom-end"
                                        data-menu-item-toggle="dropdown"
                                        data-menu-item-trigger="click|lg:click"
                                    >
                                        <button
                                            class="menu-toggle btn btn-sm btn-icon btn-light btn-clear"
                                        >
                                            <i
                                                class="ki-filled ki-dots-vertical"
                                            >
                                            </i>
                                        </button>
                                        <div
                                            class="menu-dropdown menu-default w-full max-w-[200px]"
                                            data-menu-dismiss="true"
                                        >
                                            <div class="menu-item">
                                                <a
                                                    class="menu-link"
                                                    href="/metronic/tailwind/demo1/account/home/settings-enterprise"
                                                >
                                                    <span class="menu-icon">
                                                        <i
                                                            class="ki-filled ki-setting-3"
                                                        >
                                                        </i>
                                                    </span>
                                                    <span class="menu-title">
                                                        Settings
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a
                                                    class="menu-link"
                                                    href="/metronic/tailwind/demo1/account/members/import-members"
                                                >
                                                    <span class="menu-icon">
                                                        <i
                                                            class="ki-filled ki-some-files"
                                                        >
                                                        </i>
                                                    </span>
                                                    <span class="menu-title">
                                                        Import
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a
                                                    class="menu-link"
                                                    href="/metronic/tailwind/demo1/account/activity"
                                                >
                                                    <span class="menu-icon">
                                                        <i
                                                            class="ki-filled ki-cloud-change"
                                                        >
                                                        </i>
                                                    </span>
                                                    <span class="menu-title">
                                                        Activity
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a
                                                    class="menu-link"
                                                    data-modal-toggle="#report_user_modal"
                                                    href="#"
                                                >
                                                    <span class="menu-icon">
                                                        <i
                                                            class="ki-filled ki-dislike"
                                                        >
                                                        </i>
                                                    </span>
                                                    <span class="menu-title">
                                                        Report
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center mb-2">
                                <v-lazy-image
                                    alt=""
                                    class="min-w-12 shrink-0"
                                    src="/static/media/brand-logos/office.svg"
                                />
                            </div>
                            <div class="text-center mb-7">
                                <a
                                    class="text-lg font-medium text-gray-900 hover:text-primary"
                                    href=""
                                >
                                    {{ item.title }}
                                </a>
                                <div
                                    class="text-2xs uppercase text-gray-600 text-center my-3"
                                >
                                    {{ item.type }}
                                </div>
                                <div class="text-sm text-gray-700 truncate">
                                    {{ item.description }}
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-center flex-wrap gap-2 lg:gap-5"
                            >
                                <div
                                    class="grid grid-cols-1 content-between gap-1.5 border border-dashed border-gray-300 shrink-0 rounded-md px-2.5 py-2 min-w-24 max-w-auto"
                                >
                                    <span
                                        class="text-gray-900 text-sm leading-none font-medium"
                                    >
                                        1-3 months
                                    </span>
                                    <span class="text-gray-700 text-xs">
                                        Duration
                                    </span>
                                </div>
                                <div
                                    class="grid grid-cols-1 content-between gap-1.5 border border-dashed border-gray-300 shrink-0 rounded-md px-2.5 py-2 min-w-24 max-w-auto"
                                >
                                    <span
                                        class="text-gray-900 text-sm leading-none font-medium"
                                    >
                                        Flexible
                                    </span>
                                    <span class="text-gray-700 text-xs">
                                        Location
                                    </span>
                                </div>
                                <div
                                    class="grid grid-cols-1 content-between gap-1.5 border border-dashed border-gray-300 shrink-0 rounded-md px-2.5 py-2 min-w-24 max-w-auto"
                                >
                                    <span
                                        class="text-gray-900 text-sm leading-none font-medium"
                                    >
                                        $65 hour
                                    </span>
                                    <span class="text-gray-700 text-xs">
                                        Rate
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="progress progress-primary">
                            <div class="progress-bar" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: cards -->
            <!-- begin: list -->
            <div class="hidden" id="projects_list" style="">
                <div class="flex flex-col gap-5 lg:gap-7.5">
                    <div
                        v-for="(item, index) in projects.data"
                        :key="item.id || index"
                        class="card p-7.5"
                    >
                        <div
                            class="flex items-center flex-wrap justify-between gap-5"
                        >
                            <div class="flex items-center gap-3.5">
                                <div
                                    class="flex items-center justify-center min-w-12"
                                >
                                    <v-lazy-image
                                        alt=""
                                        class="min-w-12 shrink-0"
                                        src="/static/media/brand-logos/office.svg"
                                    />
                                </div>
                                <div class="flex flex-col">
                                    <a
                                        class="text-lg font-medium text-gray-900 hover:text-primary"
                                        href=""
                                    >
                                        {{ item.title }}
                                    </a>
                                    <div
                                        class="text-sm text-gray-700 truncate max-w-xs"
                                    >
                                        {{ item.description }}
                                    </div>
                                </div>
                            </div>
                            <div
                                class="w-full flex items-center justify-between gap-5 lg:gap-12"
                            >
                                <div
                                    class="flex items-center flex-wrap gap-5 lg:gap-14"
                                >
                                    <div
                                        class="flex items-center lg:justify-center flex-wrap gap-2 lg:gap-5"
                                    >
                                        <div
                                            class="grid grid-cols-1 content-between gap-1.5 border border-dashed border-gray-300 shrink-0 rounded-md px-2.5 py-2 min-w-24 max-w-auto"
                                        >
                                            <span
                                                class="text-gray-900 text-2sm leading-none font-medium"
                                            >
                                                1-3 months
                                            </span>
                                            <span class="text-gray-700 text-xs">
                                                Duration
                                            </span>
                                        </div>
                                        <div
                                            class="grid grid-cols-1 content-between gap-1.5 border border-dashed border-gray-300 shrink-0 rounded-md px-2.5 py-2 min-w-24 max-w-auto"
                                        >
                                            <span
                                                class="text-gray-900 text-2sm leading-none font-medium"
                                            >
                                                Flexible
                                            </span>
                                            <span class="text-gray-700 text-xs">
                                                Location
                                            </span>
                                        </div>
                                        <div
                                            class="grid grid-cols-1 content-between gap-1.5 border border-dashed border-gray-300 shrink-0 rounded-md px-2.5 py-2 min-w-24 max-w-auto"
                                        >
                                            <span
                                                class="text-gray-900 text-2sm leading-none font-medium"
                                            >
                                                $65 hour
                                            </span>
                                            <span class="text-gray-700 text-xs">
                                                Rate
                                            </span>
                                        </div>
                                    </div>
                                    <div class="w-[125px] shrink-0">
                                        <span
                                            class="badge badge-primary badge-outline"
                                        >
                                            {{ item.status }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-5 lg:gap-14">
                                    <div class="menu" data-menu="true">
                                        <div
                                            class="menu-item menu-item-dropdown"
                                            data-menu-item-offset="0, 10px"
                                            data-menu-item-placement="bottom-end"
                                            data-menu-item-toggle="dropdown"
                                            data-menu-item-trigger="click|lg:click"
                                        >
                                            <button
                                                class="menu-toggle btn btn-sm btn-icon btn-light btn-clear"
                                            >
                                                <i
                                                    class="ki-filled ki-dots-vertical"
                                                >
                                                </i>
                                            </button>
                                            <div
                                                class="menu-dropdown menu-default w-full max-w-[200px]"
                                                data-menu-dismiss="true"
                                            >
                                                <div class="menu-item">
                                                    <a
                                                        class="menu-link"
                                                        href="/metronic/tailwind/demo1/account/home/settings-enterprise"
                                                    >
                                                        <span class="menu-icon">
                                                            <i
                                                                class="ki-filled ki-setting-3"
                                                            >
                                                            </i>
                                                        </span>
                                                        <span
                                                            class="menu-title"
                                                        >
                                                            Settings
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a
                                                        class="menu-link"
                                                        href="/metronic/tailwind/demo1/account/members/import-members"
                                                    >
                                                        <span class="menu-icon">
                                                            <i
                                                                class="ki-filled ki-some-files"
                                                            >
                                                            </i>
                                                        </span>
                                                        <span
                                                            class="menu-title"
                                                        >
                                                            Import
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a
                                                        class="menu-link"
                                                        href="/metronic/tailwind/demo1/account/activity"
                                                    >
                                                        <span class="menu-icon">
                                                            <i
                                                                class="ki-filled ki-cloud-change"
                                                            >
                                                            </i>
                                                        </span>
                                                        <span
                                                            class="menu-title"
                                                        >
                                                            Activity
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a
                                                        class="menu-link"
                                                        data-modal-toggle="#report_user_modal"
                                                        href="#"
                                                    >
                                                        <span class="menu-icon">
                                                            <i
                                                                class="ki-filled ki-dislike"
                                                            >
                                                            </i>
                                                        </span>
                                                        <span
                                                            class="menu-title"
                                                        >
                                                            Report
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: list -->

            <Pagination
                :paginated="projects"
                :itemsPerPageDropdownEnabled="false"
                class="text-lg"
            />
        </div>
        <!-- end: projects -->
    </div>
</template>
