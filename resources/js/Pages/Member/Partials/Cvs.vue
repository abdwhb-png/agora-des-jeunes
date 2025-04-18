<style>
.offer-bg {
    background-image: url("/static/assets/media/images/2600x1200/bg-4.png");
}
.dark .offer-bg {
    background-image: url("/static/assets/media/images/2600x1200/bg-4-dark.png");
}
</style>

<script setup>
import dayjs from "dayjs";
import { cvBuilderUrl } from "@/config/appInit";
import { ref, computed } from "vue";
import Notice from "@/Components/Base/Notice.vue";
import ProfileCompToolbar from "./ProfileCompToolbar.vue";
import NewCv from "../../App/Partials/NewCv.vue";

const props = defineProps({
    user: { type: Object, required: true },
    cvs: { type: Object, default: null },
});

const paginatedItems = computed(() => {
    return props.cvs?.data.map((cv) => {
        return {
            ...cv,
            created_at: cv.created_at
                ? dayjs(cv.created_at).format("DD/MM/YYYY à HH:mm:ss")
                : "",
        };
    });
});

const getIcon = (item) => {
    return `
    <svg
        class="w-full h-full stroke-brand-clarity fill-light"
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
        class="absolute leading-none start-2/4 top-2/4 -translate-y-2/4 -translate-x-2/4 rtl:translate-x-2/4"
    >
        <img
            src="/images/cv.png"
        />
    </div>
    `;
};
</script>

<template>
    <div class="container">
        <!-- begin: cvs -->
        <div class="flex flex-col items-stretch gap-5 lg:gap-7.5">
            <!-- begin: toolbar -->
            <ProfileCompToolbar
                :data-count="cvs.total + ' CVS'"
                search-key="search_cv"
                tab-key="cvs"
            >
                <template #newBtn>
                    <NewCv />
                </template>
            </ProfileCompToolbar>
            <!-- end: toolbar -->
            <Notice
                title="Clique sur un cv pour le modifier ou le télécharger."
            />
            <!-- begin: cards -->
            <div id="cvs_cards">
                <div
                    class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5 lg:gap-7.5"
                >
                    <a
                        v-for="(item, index) in paginatedItems"
                        :key="item.id || index"
                        class="card border-2 border-dashed border-brand-clarity bg-center bg-[length:750px] bg-no-repeat offer-bg"
                        :href="`${cvBuilderUrl}/dashboard/resume/${item.resume_id}/edit`"
                        target="_blank"
                        :style="{
                            borderColor: item.theme_color + '80' || '#ff6f1e33',
                        }"
                    >
                        <div class="card-body grid items-center">
                            <div class="flex flex-col gap-5">
                                <div class="flex justify-center pt-5">
                                    <div
                                        class="relative size-[90px] shrink-0"
                                        v-html="getIcon(item)"
                                    ></div>
                                </div>
                                <div class="flex flex-col text-center">
                                    <span
                                        class="text-1.5xl font-semibold text-gray-900 hover:text-primary-active mb-px"
                                    >
                                        {{ item.title }}
                                    </span>
                                    <span
                                        class="text-sm font-medium text-gray-600"
                                    >
                                        Date de création : {{ item.created_at }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- end: cards -->

            <!-- begin: list -->
            <div id="cvs_list" class="hidden" style="">
                <div class="flex flex-col gap-5 lg:gap-7.5">
                    <a
                        v-for="(item, index) in paginatedItems"
                        :key="item.id || index"
                        class="card border-2 border-dashed border-brand-clarity bg-center bg-[length:600px] bg-no-repeat offer-bg"
                        :href="`${cvBuilderUrl}/dashboard/resume/${item.resume_id}/edit`"
                        target="_blank"
                    >
                        <div class="card-body px-1.5">
                            <div class="flex items-center justify-center gap-5">
                                <div class="flex justify-center">
                                    <div
                                        class="relative size-[70px] shrink-0"
                                        v-html="getIcon(item)"
                                    ></div>
                                </div>
                                <div class="flex flex-col text-start">
                                    <span
                                        class="text-xl font-semibold text-gray-900 hover:text-primary-active mb-px"
                                    >
                                        {{ item.title }}
                                    </span>
                                    <span
                                        class="text-sm font-medium text-gray-600"
                                    >
                                        Date de création : {{ item.created_at }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- end: cards -->

            <Pagination
                :paginated="cvs"
                :itemsPerPageDropdownEnabled="false"
                class="text-lg"
            />
        </div>
        <!-- end: cvs -->
    </div>
</template>
