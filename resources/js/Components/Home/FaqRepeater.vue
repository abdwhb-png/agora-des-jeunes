<script setup lang="ts">
import { ref, watch, computed } from "vue";
import { useToast } from "../ui/toast";
import Fuse from "fuse.js";
import { CustomPaginatedData } from "@/types";

const props = defineProps({
    data: { type: Object as () => CustomPaginatedData, required: true },
    searchUrl: { type: String, required: true },
});

const { toast } = useToast();
const items = ref([]);
const filteredResults = ref([]);

const query = ref("");
const loading = ref(false);

const options = {
    keys: ["category", "question", "answer"],
    includeScore: true,
    threshold: 0.7,
};

// Créer une instance de Fuse
const fuse = new Fuse(items.value, options);

const performSearch = async () => {
    if (!query.value) {
        filteredResults.value = items.value;
        return;
    }
    loading.value = true;
    try {
        const res = await axios.post(props.searchUrl, {
            query: query.value,
            data: items.value,
        });
        console.log(res);

        if (!res.data.data.length) {
            throw new Error("No results found with ai search");
        }
    } catch (error) {
        console.log(error);
        const searchResults = fuse.search(query.value);
        filteredResults.value = searchResults.map((result) => result.item);
        console.log(searchResults);
    } finally {
        loading.value = false;
    }
};

watch(
    props.data,
    (newData) => {
        items.value = Object.values(newData.list.data).filter(
            (item) => item.is_active,
        );
        filteredResults.value = items.value;
    },
    { immediate: true },
);
</script>
<template>
    <section class="section-faq">
        <div class="padding-global section-padding-regular">
            <div class="container is-secondary">
                <div class="margin-bottom margin-40px">
                    <div class="flex gap-3">
                        <IconField>
                            <InputIcon class="pi pi-search" />
                            <InputText
                                v-model="query"
                                placeholder="Rechercher une question"
                                size="large"
                                fluid
                            />
                        </IconField>
                        <Button
                            icon="pi pi-search"
                            severity="contrast"
                            :loading="loading"
                            @click="performSearch"
                        />
                        <Button
                            v-if="query"
                            icon="pi pi-times"
                            severity="secondary"
                            raised
                            @click="
                                query = '';
                                performSearch;
                            "
                        />
                    </div>
                </div>
                <div class="faq-main">
                    <div class="faq-tab-menu">
                        <Message
                            v-if="!filteredResults.length"
                            severity="secondary"
                            >Aucun résultat trouvé</Message
                        >
                        <div
                            v-for="(item, index) in filteredResults"
                            :key="item.id || item.question"
                            data-hover="false"
                            data-delay="0"
                            class="faq-items-wrapper w-dropdown"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                transform-style: preserve-3d;
                                opacity: 1;
                                background-color: rgb(247, 247, 247);
                            "
                        >
                            <div
                                class="faq-question-area w-dropdown-toggle"
                                id="w-dropdown-toggle-1"
                                aria-controls="w-dropdown-list-1"
                                aria-haspopup="menu"
                                aria-expanded="false"
                                role="button"
                                tabindex="0"
                            >
                                <p class="heading-custom-h5 is-pre-wrap">
                                    {{ item.question }}
                                </p>
                                <div class="faq-icon-wrapper">
                                    <div
                                        class="faq-plus-horizontal"
                                        style="opacity: 1"
                                    ></div>
                                    <div
                                        class="faq-plus-vertical"
                                        style="
                                            transform: translate3d(
                                                    0px,
                                                    0px,
                                                    0px
                                                )
                                                scale3d(1, 1, 1) rotateX(0deg)
                                                rotateY(0deg) rotateZ(0deg)
                                                skew(0deg, 0deg);
                                            transform-style: preserve-3d;
                                        "
                                    ></div>
                                </div>
                            </div>
                            <nav
                                class="faq-dropdown-list w-dropdown-list"
                                style="
                                    width: 100%;
                                    height: 0px;
                                    opacity: 0;
                                    display: none;
                                "
                                id="w-dropdown-list-1"
                                aria-labelledby="w-dropdown-toggle-1"
                            >
                                <div class="faq-answer-wrapper">
                                    <div
                                        class="faq-answer-text"
                                        v-html="item.answer"
                                    ></div>
                                </div>
                            </nav>
                        </div>
                        <div>
                            <Pagination
                                :paginated="data.list"
                                :items-per-page-dropdown-enabled="false"
                                :filter-name="data.filter_name"
                                class="text-lg"
                            ></Pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
