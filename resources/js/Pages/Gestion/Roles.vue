<script setup lang="ts">
import { ref } from "vue";
import { FILTER_NAMES } from "@/constants";
import { useFilter } from "@/composables/useFilter";
import { LaravelPagination } from "@/types";
import CreateForm from "@/Components/Roles/RoleForm.vue";
import Repeater from "@/Components/Roles/Repeater.vue";

const props = defineProps({
    roles: {
        type: Object as () => LaravelPagination<any>,
        default: () => ({}),
    },
    can: Object,
    filters: Object,
});

const filterName = FILTER_NAMES.roles;
const showForm = ref(false);

const { filters, loading, hasFilters, resetFilters } = useFilter({
    filterName: filterName,
    initialFilters: props.filters[filterName],
});
</script>

<template>
    <MainLayout title="Roles">
        <Dialog
            v-model:visible="showForm"
            modal
            :dismissable-mask="true"
            header="Créer un role"
            :style="{ width: '25rem' }"
        >
            <div class="pt-2">
                <CreateForm
                    @created="showForm = false"
                    @canceled="showForm = false"
                />
            </div>
        </Dialog>

        <div class="card">
            <div class="card-header gap-2">
                <h3 class="card-title">Liste des roles</h3>
                <div class="flex gap-5">
                    <button
                        :disabled="!$page.props.can.createRole"
                        type="button"
                        class="btn btn-sm btn-primary shrink-0"
                        @click="showForm = true"
                    >
                        <i class="ki-filled ki-plus"></i>
                        Nouveau Role
                    </button>
                </div>
            </div>
            <div class="card-body">
                <SearchInput
                    v-model="filters.search"
                    :has-filters="hasFilters"
                    :loading="loading"
                    @reset="resetFilters()"
                    placeholder="Rechercher un rôle"
                />
                <Repeater
                    :data="roles.data"
                    :show-edit="can.editRole"
                    :show-search="false"
                />
            </div>

            <div class="card-footer justify-center md:justify-end">
                <Pagination :paginated="roles" :filter-name="filterName" />
            </div>
        </div>
    </MainLayout>
</template>
