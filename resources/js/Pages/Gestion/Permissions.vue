<script setup>
import { ref } from "vue";
import Repeater from "@/Components/Permissions/Repeater.vue";
import CreateForm from "@/Components/Permissions/PermissionForm.vue";
import Pagination from "@/Components/Tables/Pagination.vue";
import SearchInput from "@/Components/SearchInput.vue";

const filterName = "permissions";
const showForm = ref(false);
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
                        >{{ $page.props.permissions.total }} au total</span
                    >
                </h3>
                <div class="flex gap-5">
                    <button
                        :disabled="!$page.props.can.createPermission"
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
                    :filter-name="filterName"
                    placeholder="Rechercher une permission"
                />
                <Repeater
                    :data="$page.props.permissions.data"
                    :show-delete="true"
                    :show-search="false"
                />
            </div>
            <div class="card-footer">
                <Pagination
                    :paginated="$page.props.permissions"
                    :filter-name="filterName"
                />
            </div>
        </div>
    </MainLayout>
</template>
