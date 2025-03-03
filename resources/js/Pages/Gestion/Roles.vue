<script setup>
import { ref } from "vue";
import CreateForm from "@/Components/Roles/RoleForm.vue";
import Repeater from "@/Components/Roles/Repeater.vue";

const showForm = ref(false);
const filterName = "roles";
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
                    :filter-name="filterName"
                    placeholder="Rechercher une permission"
                />
                <Repeater
                    :data="$page.props.roles.data"
                    :show-edit="$page.props.can.editRole"
                    :show-search="false"
                />
            </div>

            <div class="card-footer justify-center md:justify-end">
                <Pagination
                    :paginated="$page.props.roles"
                    :filter-name="filterName"
                />
            </div>
        </div>
    </MainLayout>
</template>
