<template>
    <div
        class="flex justify-center md:justify-between flex-col md:flex-row gap-5 text-gray-600 text-2sm font-medium"
        :class="sizeClass"
    >
        <!-- Sélection du nombre de lignes par page -->
        <div
            class="flex items-center gap-2 order-2 md:order-1"
            v-if="itemsPerPageDropdownEnabled"
        >
            Lignes par page
            <select
                class="select select-sm w-16"
                :disabled="loading || !paginated.total"
                data-datatable-size="true"
                name="per_page"
                v-model="itemsCountInTable"
            >
                <option
                    v-for="(perPage, index) in itemsPerPage"
                    :key="index"
                    :value="perPage"
                >
                    {{ perPage }}
                </option>
            </select>
        </div>

        <!-- Boutons de pagination -->
        <div class="flex items-center gap-4 order-1 md:order-2">
            <span data-datatable-info="true">{{ paginationInfo }}</span>
            <div class="pagination">
                <div class="pagination">
                    <!-- Bouton Précédent -->
                    <Link
                        class="btn"
                        :class="{ disabled: !paginated.prev_page_url }"
                        :href="paginated.prev_page_url ?? ''"
                        prefetch
                        cache-for="1m"
                    >
                        <i
                            class="ki-outline ki-black-left rtl:transform rtl:rotate-180"
                        ></i>
                    </Link>

                    <!-- Affichage dynamique des pages -->
                    <Link
                        preserve-scroll
                        v-for="link in visiblePageNumbers"
                        prefetch
                        cache-for="1m"
                        :key="link.label"
                        :href="link.url ?? ''"
                        class="btn"
                        :class="{
                            'active disabled': link.active,
                        }"
                    >
                        {{ link.label }}
                    </Link>

                    <!-- Bouton Suivant -->
                    <Link
                        class="btn"
                        :class="{ disabled: !paginated.next_page_url }"
                        prefetch
                        cache-for="1m"
                        :href="paginated.next_page_url ?? ''"
                    >
                        <i
                            class="ki-outline ki-black-right rtl:transform rtl:rotate-180"
                        ></i>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, type WritableComputedRef } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { LaravelPagination } from "@/types";
import { itemsPerPage } from "@/utils/dataTable";
import { useToast } from "primevue";

const emits = defineEmits(["update:itemsPerPage"]);

const props = defineProps({
    paginated: {
        type: Object as () => LaravelPagination<any>,
        required: false,
        default: {},
    },
    filterName: {
        type: String,
        required: false,
        default: null,
    },
    itemsPerPageDropdownEnabled: {
        type: Boolean,
        default: true,
    },
    maxVisiblePages: {
        type: Number,
        required: false,
        default: 5,
    },
    sizeClass: String,
});

const page = usePage();
const toast = useToast();
const loading = ref(false);

const perPage = ref(props.paginated.per_page);

const itemsCountInTable: WritableComputedRef<number> = computed({
    get(): number {
        return (
            page.props.filters[props.filterName]?.per_page ||
            props.paginated.per_page
        );
    },
    set(value: number): void {
        if (props.filterName) {
            onFilter({
                per_page: value,
            });
        }

        emits("update:itemsPerPage", value);
    },
});

const currentPage = computed(() => props.paginated.current_page);

// Calcul des indices de début et de fin des éléments affichés
const from = computed(
    () => (currentPage.value - 1) * props.paginated.per_page + 1,
);
const to = computed(() =>
    Math.min(
        currentPage.value * props.paginated.per_page,
        props.paginated.total,
    ),
);
const paginationInfo = computed(
    () => `${from.value} à ${to.value} sur ${props.paginated.total}`,
);

// Filtrer les liens de pagination pour exclure "Précédent" et "Suivant"
const filteredLinks = computed(() => props.paginated.links?.slice(1, -1));

// Limiter à 5 pages visibles à la fois
const visiblePageNumbers = computed(() => {
    let start = Math.max(
        currentPage.value - Math.floor(props.maxVisiblePages / 2),
        0,
    );
    let end = start + props.maxVisiblePages;

    return filteredLinks.value?.slice(start, end);
});

const onFilter = async (filters: Object) => {
    router.post(
        route("filter.store"),
        {
            type: props.filterName,
            filters: filters,
        },
        {
            preserveScroll: true,
            onBefore: () => {
                loading.value = true;
            },
            onSuccess: (page: any) => {
                if (filters["per_page"]) {
                    perPage.value = filters["per_page"];
                }

                toast.add({
                    severity: "success",
                    life: 3000,
                    detail:
                        page.props.flash.success ||
                        "Filtres mis à jour avec succès",
                });
            },
            onFinish: () => {
                loading.value = false;
                if (props.paginated.current_page > props.paginated.last_page) {
                    const url = filteredLinks.value?.at(-1)?.url;
                    router.get(url);
                }
            },
        },
    );
};
</script>
