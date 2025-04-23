<template>
    <div class="flex gap-2 pl-2">
        <DropdownMenu v-if="showFilters">
            <DropdownMenuTrigger>
                <button
                    class="btn btn-xs btn-primary"
                    :class="hasFilters ? 'btn-primary btn-outline' : 'btn-dark'"
                >
                    {{ hasFilters ? "Filtres appliqués" : "Filtrage" }}
                </button>
            </DropdownMenuTrigger>
            <DropdownMenuContent>
                <template v-for="(key, index) in filterKeys" :key="index">
                    <DropdownMenuLabel
                        >Filtrer par : {{ key }}</DropdownMenuLabel
                    >
                    <DropdownMenuSeparator />

                    <DropdownMenuRadioGroup v-model="form.filters[key]">
                        <slot :name="key + 'Content'" />
                    </DropdownMenuRadioGroup>

                    <DropdownMenuLabel>
                        <button class="btn btn-xs btn-light" @click="reset">
                            <i class="ki-outline ki-cross"></i>
                            Réinitialiser
                        </button>
                    </DropdownMenuLabel>
                </template>
            </DropdownMenuContent>
        </DropdownMenu>
        <slot name="searchContent">
            <SearchInput
                v-model="form.filters.search"
                :loading="loading"
                @reset="reset"
            />
        </slot>
    </div>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { ref, watch, reactive, computed } from "vue";
import { toast } from "vue-sonner";
import throttle from "lodash/throttle";
import pickBy from "lodash/pickBy";
import mapValues from "lodash/mapValues";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
    DropdownMenuRadioGroup,
} from "@/Components/ui/dropdown-menu";

const emits = defineEmits(["searched", "reseted"]);
const props = defineProps({
    maxWidth: {
        type: Number,
        default: 300,
    },
    showFilters: {
        type: Boolean,
        default: true,
    },
    filterName: {
        type: String,
        default: null,
    },
    filterKeys: {
        type: Array,
        default: () => [],
    },
    dataFilters: Object,
});

const loading = ref(false);

const form = reactive({
    type: props.filterName,
    filters: {
        search: props.dataFilters[props.filterName]?.search || null,
        // [props.filterName]: props.dataFilters[props.filterName],
    },
});

props.filterKeys.forEach((key) => {
    form.filters[key] = props.dataFilters[props.filterName][key] || null;
});

const hasFilters = computed(() => {
    return Object.values(form.filters).some((value) => value !== null);
});

const submit = (url, method, onSuccess) => {
    router.visit(url, {
        method: props.filterName ? "post" : "get",
        data: pickBy(form, (value) => value !== null && value !== ""),
        preserveState: true,
        onStart: () => (loading.value = true),
        onSuccess: (data) => {
            if (onSuccess) {
                onSuccess();
            }
        },
        onError: (errors) => {
            console.error("Filters failed:", errors);
            toast("Impossible de filtrer", {
                description: "Les filtres n'ont pas pu être appliqués.",
                variant: "danger",
            });
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

watch(
    form,
    throttle(() => {
        const url = props.filterName
            ? route("filter.store")
            : route(route().current());

        const method = props.filterName ? "post" : "get";

        submit(url, method, () => {
            emits(
                "searched",
                pickBy(form, (value) => value !== null && value !== ""),
            );
        });
    }, 250),
    { deep: true },
);

function reset() {
    // Reset only the filters object, preserving the form structure
    form.filters = mapValues(form.filters, () => null);
    form.type = props.filterName; // Preserve the type

    const url = props.filterName
        ? route("filter.reset")
        : route(route().current());
    const method = props.filterName ? "patch" : "get";

    submit(url, method, () => {
        emits("reseted");
        toast("Filtres réinitialisés", {
            description: "Les filtres ont été réinitialisés avec succès.",
        });
    });
}
</script>
