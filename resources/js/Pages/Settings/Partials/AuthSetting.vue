<script setup>
import { dialogBreakpoints } from "@/utils/helpers";
import { ref } from "vue";
import TwoFactorAuthenticationForm from "./TwoFactorAuthenticationForm.vue";
import PasswordForm from "@/Pages/Account/Partials/PasswordForm.vue";

defineProps({
    user: {
        type: Object,
        required: true,
    },
    confirmsTwoFactorAuthentication: {
        type: Boolean,
        default: null,
    },
});

const editPwd = ref(false);
const setup2fa = ref(false);
</script>

<template>
    <Dialog
        v-model:visible="setup2fa"
        :style="{ width: '50rem' }"
        modal
        header="Paramétrer l'authentification à 2 facteurs"
        :breakpoints="dialogBreakpoints"
    >
        <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
            <TwoFactorAuthenticationForm
                :requires-confirmation="confirmsTwoFactorAuthentication"
                class="mt-10 sm:mt-0"
            />
        </div>
    </Dialog>
    <Dialog
        v-model:visible="editPwd"
        :style="{ width: '50rem' }"
        modal
        :breakpoints="dialogBreakpoints"
    >
        <PasswordForm />
    </Dialog>
    <div class="flex flex-col gap-5 lg:gap-7.5" id="auth_settings">
        <div class="card min-w-full">
            <div class="card-header">
                <h3 class="card-title">Authentification</h3>
            </div>
            <div class="card-table scrollable-x-auto pb-3">
                <table class="table align-middle text-sm text-gray-500">
                    <tbody>
                        <tr>
                            <td class="text-gray-600 font-normal">
                                Mot de passe
                            </td>
                            <td class="text-gray-700 font-normal">
                                {{
                                    user.last_password_updated_at ??
                                    "A mettre à jour régulièrement"
                                }}
                            </td>
                            <td class="text-end">
                                <a
                                    class="btn btn-sm btn-icon btn-icon-lg link"
                                    href="javascript:void(0);"
                                    @click="editPwd = true"
                                >
                                    <i class="ki-filled ki-notepad-edit"> </i>
                                </a>
                            </td>
                        </tr>
                        <tr
                            v-if="
                                typeof confirmsTwoFactorAuthentication ===
                                'boolean'
                            "
                        >
                            <td class="text-gray-600 font-normal">2FA</td>
                            <td class="text-gray-700 font-normal">
                                Authentification à 2 facteurs
                            </td>
                            <td class="text-end">
                                <a
                                    class="btn btn-link btn-sm"
                                    href="javascript:void(0);"
                                    @click="setup2fa = true"
                                >
                                    Paramétrer
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
