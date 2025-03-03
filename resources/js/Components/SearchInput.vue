<template>
    <div class="flex flex-col gap-0.5">
        <div class="flex gap-2 max-w-[900px]">
            <div class="input input-sm">
                <i class="ki-filled ki-magnifier"> </i>
                <input
                    :placeholder="placeholder"
                    type="text"
                    @input="onSearch"
                    v-model="form.filters.search"
                />
            </div>
            <Button
                class="btn btn-sm btn-outline btn-light btn-icon"
                unstyled
                @click="reset"
                :loading="form.processing"
                icon="ki-filled ki-cross"
            />
        </div>
        <ProgressBar
            v-if="form.processing"
            mode="indeterminate"
            style="height: 5px"
        />
    </div>
</template>

<script setup>
import { sleep } from "@/utils/helpers";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const emits = defineEmits(["searched"]);

const props = defineProps({
    filterName: {
        type: String,
        required: false,
        default: null,
    },
    placeholder: { type: String, default: "Rechercher..." },
});

const page = usePage();

const controller = ref(null);

const form = useForm({
    type: props.filterName,
    filters: {
        search: null,
    },
});

const onSearch = async (event) => {
    const input = event.target.value;

    setTimeout(() => {
        search(input);
    }, 500);
};

watch(
    () => page.props.filters,
    (newFilters) => {
        form.filters.search = newFilters[props.filterName]?.search || null;
        if (form.filters.search) {
            // search(form.filters.search);
        }
    },
    { immediate: true, deep: true },
);

function reset() {
    form.filters.search = null;
    if (props.filterName) {
        form.patch(route("filter.reset"));
    } else {
        router.reload({
            preserveState: true,
        });
    }

    emits("searched");
}

async function search(input) {
    // Annuler la requête précédente si elle existe
    if (controller.value) {
        controller.value.abort();
    }

    // Créer un nouveau contrôleur pour cette requête
    controller.value = new AbortController();
    const signal = controller.value.signal;

    // await sleep(700);

    if (props.filterName) {
        form.post(route("filter.store"), {
            preserveScroll: true,
            signal,
        });
    } else {
        const url = route(route().current());
        router.get(
            url,
            {
                search: input,
            },
            {
                preserveScroll: true,
                signal,
            },
        );
    }

    emits("searched");
}
</script>
