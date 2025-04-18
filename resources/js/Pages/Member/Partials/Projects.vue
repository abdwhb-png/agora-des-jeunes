<script setup>
import ProfileCompToolbar from "./ProfileCompToolbar.vue";
import NewProject from "../../App/Partials/NewProject.vue";
import ProjectContent from "./ProjectContent.vue";

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
                                <ProjectContent
                                    :project="item"
                                    section="dropdown"
                                />
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
                                <ProjectContent
                                    :project="item"
                                    section="metadata"
                                />
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
                                        <ProjectContent
                                            :project="item"
                                            section="metadata"
                                        />
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
                                    <ProjectContent
                                        :project="item"
                                        section="dropdown"
                                    />
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
