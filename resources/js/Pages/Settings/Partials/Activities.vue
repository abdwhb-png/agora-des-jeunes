<script setup lang="ts">
import { dialogBreakpoints } from "@/utils/helpers";
import { computed, ref, onMounted } from "vue";
import { useUserStore } from "@/stores/user";
import { LaravelPagination } from "@/types/laravel";
import LogoutOtherBrowserSessionsForm from "./LogoutOtherBrowserSessionsForm.vue";
import AccountActivities from "./AccountActivities.vue";

defineProps({
    accountActivities: {
        type: Object as () => LaravelPagination<any>,
        default: null,
    },
});

const userStore = useUserStore();

const visible = ref(false);
const dialogComponent = ref(false);

const showDialog = (component) => {
    visible.value = true;
    dialogComponent.value = component;
};

const dialogTitle = computed(() => {
    switch (dialogComponent.value) {
        case "account_activities":
            return "Activités du compte";
        case "sessions":
            return "Appareils connectés";
        default:
            return "";
    }
});

onMounted(async () => {
    await userStore.fetchSessions();
});
</script>

<template>
    <Dialog
        v-model:visible="visible"
        :header="dialogTitle"
        @hide="visible = false"
        :style="{ width: '70rem' }"
        maximizable
        modal
        :breakpoints="dialogBreakpoints"
    >
        <LogoutOtherBrowserSessionsForm
            v-if="dialogComponent == 'sessions'"
            :sessions="userStore.sessions"
        />
        <AccountActivities
            v-if="dialogComponent == 'account_activities'"
            :paginated="accountActivities"
        />
    </Dialog>
    <div class="flex flex-col gap-5 lg:gap-7.5" id="auth_settings">
        <div class="card min-w-full">
            <div class="card-header">
                <h3 class="card-title">Activités</h3>
            </div>
            <div class="card-table scrollable-x-auto pb-3">
                <table class="table align-middle text-sm text-gray-500">
                    <tbody>
                        <tr>
                            <td class="text-gray-600 font-normal">
                                <i class="ki-filled ki-chart-line-star"></i>
                                Activités du compte
                            </td>
                            <td class="text-gray-700 font-normal">
                                Consulte l'historique des activités et surveille
                                les accès à ton compte.
                            </td>
                            <td class="text-end">
                                <a
                                    class="btn btn-sm btn-icon btn-icon-lg link"
                                    href="javascript:void(0);"
                                    @click="showDialog('account_activities')"
                                >
                                    <i class="ki-filled ki-eye"> </i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-600 font-normal">
                                <i class="ki-filled ki-desktop-mobile"></i>
                                Appareils connectés
                            </td>
                            <td class="text-gray-700 font-normal">
                                Consulte et gère les appareils connectés à ton
                                compte.
                            </td>
                            <td class="text-end">
                                <a
                                    class="btn btn-sm btn-icon btn-icon-lg link"
                                    href="javascript:void(0);"
                                    @click="showDialog('sessions')"
                                >
                                    <i class="ki-filled ki-eye"> </i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
