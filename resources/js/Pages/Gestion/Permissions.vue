<script setup lang="ts">
import { ref } from "vue";
import { FILTER_NAMES } from "@/constants";
import { useFilter } from "@/composables/useFilter";
import { LaravelPagination } from "@/types";
import Repeater from "@/Components/Permissions/Repeater.vue";
import CreateForm from "@/Components/Permissions/PermissionForm.vue";

const props = defineProps({
    permissions: {
        type: Object as () => LaravelPagination<any>,
        default: () => ({}),
    },
    can: Object,
    filters: Object,
});

const filterName = FILTER_NAMES.permissions;
const showForm = ref(false);

const { filters, loading, hasFilters, resetFilters } = useFilter({
    filterName: filterName,
    initialFilters: props.filters[filterName],
});
</script>

<template>
    <MainLayout title="Permissions">
        <Dialog
            v-model:visible="showForm"
            modal
            :dismissable-mask="true"
            header="Créer une permission"
            :style="{ width: '25rem' }"
        >
            <div class="pt-2">
                <CreateForm
                    @created="showForm = false"
                    @canceled="showForm = false"
                />
            </div>
        </Dialog>
        <div class="card h-full">
            <div class="card-header gap-2">
                <h3 class="card-title">
                    Liste des permissions
                    <span class="text-slate-500"
                        >{{ permissions.total }} au total</span
                    >
                </h3>
                <div class="flex gap-5">
                    <button
                        :disabled="!can.createPermission"
                        type="button"
                        class="btn btn-sm btn-primary shrink-0"
                        @click="showForm = true"
                    >
                        <i class="ki-filled ki-plus"></i>
                        Nouvelle Permission
                    </button>
                </div>
            </div>
            <div class="card-body">
                <SearchInput
                    v-model="filters.search"
                    :has-filters="hasFilters"
                    :loading="loading"
                    @reset="resetFilters()"
                    placeholder="Rechercher une permission"
                />
                <Repeater
                    :data="permissions.data"
                    :show-delete="true"
                    :show-search="false"
                />
            </div>
            <div class="card-footer">
                <Pagination
                    :paginated="permissions"
                    :filter-name="filterName"
                />
            </div>
        </div>
    </MainLayout>
</template>
