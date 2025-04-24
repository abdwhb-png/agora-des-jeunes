<script setup lang="ts">
import { ref } from "vue";
import { getIcon } from "@/utils";
import { LaravelPagination } from "@/types";
import MyListItem from "@/Components/Shared/MyListItem.vue";
import NewProject from "../../Components/Projects/NewProject.vue";
import ProjectPreview from "../../Components/Projects/ProjectPreview.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    projects: {
        type: Object as () => LaravelPagination<any>,
        default: [],
    },
});

const visible = ref(false);
const currentItem = ref(null);

const showProjectDetails = (project) => {
    currentItem.value = project;
    visible.value = true;
};
</script>

<template>
    <MainLayout title="Projets">
        <Dialog
            v-model:visible="visible"
            modal
            :dismissable-mask="true"
            :style="{ width: '70rem' }"
            :breakpoints="{ '575px': '98%' }"
        >
            <ProjectPreview
                v-if="currentItem"
                :title="currentItem.title"
                :description="currentItem.description"
                :markdown_content="currentItem.markdown_content"
                :html_content="currentItem.html_content"
                :created_at="currentItem.created_at"
                :owner="currentItem.user"
            >
                <template #actions>
                    <Link
                        :href="`/projects/${currentItem.id}/edit`"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Éditer
                    </Link>
                    <Link
                        :href="`/projects/${currentItem.id}`"
                        class="ml-3 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Voir plus
                    </Link>
                </template>
            </ProjectPreview>
        </Dialog>
        <div class="flex flex-col max-w-3xl mx-auto md:px-4 md:py-8 gap-4">
            <NewProject />
            <template
                v-for="(project, index) in projects.data"
                :key="project.id || index"
            >
                <MyListItem
                    :title="project.title"
                    :description="project.description"
                    variant="card"
                    @click="showProjectDetails(project)"
                    class="cursor-pointer hover:bg-gray-50 transition-colors"
                >
                    <template #icon>
                        <div class="relative size-[45px] shrink-0">
                            <svg
                                class="w-full h-full stroke-gray-300 fill-gray-100"
                                fill="none"
                                height="48"
                                viewBox="0 0 44 48"
                                width="44"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506
			18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937
			39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z"
                                    fill=""
                                ></path>
                                <path
                                    d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506
			18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937
			39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z"
                                    stroke=""
                                ></path>
                            </svg>
                            <div
                                class="absolute inset-0 flex items-center justify-center"
                            >
                                <i
                                    class="text-1.5xl text-gray-500 ki-filled"
                                    :class="getIcon('projet')"
                                ></i>
                            </div>
                        </div>
                    </template>
                </MyListItem>
            </template>
            <div
                v-if="projects.total > projects.data.length"
                class="flex justify-center mt-4"
            >
                <Link
                    :href="projects.next_page_url"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md"
                >
                    Charger plus
                </Link>
            </div>
        </div>
    </MainLayout>
</template>
