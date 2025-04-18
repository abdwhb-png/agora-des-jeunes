<script setup>
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { dialogBreakpoints } from "@/utils/helpers";
import TwoFactorAuthenticationForm from "./TwoFactorAuthenticationForm.vue";
import EmailForm from "@/Pages/Account/Partials/EmailForm.vue";
import PasswordForm from "@/Pages/Account/Partials/PasswordForm.vue";
import { Mail } from "lucide-vue-next";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    confirmsTwoFactorAuthentication: {
        type: Boolean,
        default: null,
    },
});

const visible = ref(false);
const dialogComponent = ref(false);

const form = useForm({
    two_step_verification: Boolean(props.user.account.two_step_verification),
});

const showDialog = (component) => {
    visible.value = true;
    dialogComponent.value = component;
};

const update2StepVerification = () => {
    form.put(route("user.account.update", props.user.id), {
        preserveScroll: true,
        onSuccess: () => {},
    });
};

const dialogTitle = computed(() => {
    switch (dialogComponent.value) {
        case "email":
            return "Changement d'email";
        case "password":
            return "Changement de mot de passe";
        case "2fa":
            return "Paramétrade de l'authentification 2fa";
        default:
            return "";
    }
});
</script>

<template>
    <Dialog
        v-model:visible="visible"
        :header="dialogTitle"
        @hide="visible = false"
        :style="{ width: '50rem' }"
        modal
        :breakpoints="dialogBreakpoints"
    >
        <EmailForm
            v-if="dialogComponent == 'email'"
            :user="user"
            :has-email-verification="
                $page.props.jetstream?.hasEmailVerification ?? false
            "
        />
        <PasswordForm
            v-if="dialogComponent == 'password'"
            :show-header="false"
        />
        <TwoFactorAuthenticationForm
            v-else-if="dialogComponent == '2fa'"
            :requires-confirmation="confirmsTwoFactorAuthentication"
            class="mt-10 sm:mt-0"
        />
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
                            <td
                                class="text-gray-600 font-normal flex items-center gap-1"
                            >
                                <Mail :size="14" />
                                Email
                            </td>
                            <td class="text-gray-700 font-normal">
                                Changement d'email
                            </td>
                            <td class="text-end">
                                <a
                                    class="btn btn-sm btn-icon btn-icon-lg link"
                                    href="javascript:void(0);"
                                    @click="showDialog('email')"
                                >
                                    <i class="ki-filled ki-notepad-edit"> </i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-600 font-normal">
                                <i class="ki-filled ki-lock"></i>
                                Mot de passe
                            </td>
                            <td class="text-gray-700 font-normal">
                                {{
                                    user.last_password_updated_at ??
                                    "Changement de mot de passe"
                                }}
                            </td>
                            <td class="text-end">
                                <a
                                    class="btn btn-sm btn-icon btn-icon-lg link"
                                    href="javascript:void(0);"
                                    @click="showDialog('password')"
                                >
                                    <i class="ki-filled ki-notepad-edit"> </i>
                                </a>
                            </td>
                        </tr>
                        <tr
                            v-if="
                                $page.props.jetstream
                                    .canManageTwoFactorAuthentication
                            "
                        >
                            <td class="text-gray-600 font-normal">
                                <i class="ki-filled ki-shield-tick"></i>
                                2FA
                            </td>
                            <td class="text-gray-700 font-normal">
                                Authentification à deux facteurs
                            </td>
                            <td class="text-end">
                                <a
                                    class="btn btn-link btn-sm"
                                    href="javascript:void(0);"
                                    @click="showDialog('2fa')"
                                >
                                    Activer
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-600 font-normal">
                                <i class="ki-filled ki-password-check"></i>
                                Vérification en deux étapes
                            </td>
                            <td class="text-gray-700 font-normal">
                                En l'activant tu ajoutes une couche
                                supplémentaire de sécurité à ton compte.
                            </td>
                            <td class="text-end">
                                <div class="switch switch-sm">
                                    <input
                                        @change="update2StepVerification"
                                        :checked="
                                            form.two_step_verification
                                                ? true
                                                : false
                                        "
                                        v-model="form.two_step_verification"
                                        name="two_step_verification"
                                        type="checkbox"
                                    />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
