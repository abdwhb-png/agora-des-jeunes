<script setup>
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import EmailForm from "../Account/Partials/EmailForm.vue";
import { dialogBreakpoints } from "@/utils/helpers";

const props = defineProps({
    status: String,
});

const editEmail = ref(false);
const form = useForm({});

const submit = () => {
    form.post(route("verification.send"));
};

const verificationLinkSent = computed(
    () => props.status === "verification-link-sent",
);
</script>

<template>
    <Head title="Verification d'email" />
    <AuthLayout>
        <Dialog
            v-model:visible="editEmail"
            :style="{ width: '50rem' }"
            modal
            :breakpoints="dialogBreakpoints"
        >
            <EmailForm
                :user="$page.props.auth.user"
                @updated="editEmail = false"
            />
        </Dialog>
        <div class="card max-w-[440px] w-full">
            <div
                action="#"
                class="card-body p-10"
                id="check_email_form"
                method="post"
            >
                <div class="flex justify-center py-10">
                    <img
                        alt="image"
                        class="dark:hidden max-h-[130px]"
                        src="/static/media/illustrations/30.svg"
                    />
                    <img
                        alt="image"
                        class="light:hidden max-h-[130px]"
                        src="/static/media/illustrations/30-dark.svg"
                    />
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-3">
                    Vérifie ta boîte mail
                </h3>
                <div class="text-2sm text-center text-gray-700 mb-7.5">
                    Clique sur le lien envoyer à
                    <a
                        class="text-2sm text-gray-900 font-medium hover:text-primary-active"
                        href="#"
                    >
                        {{ $page.props.auth.user.email }}
                    </a>
                    <br />
                    pour activer ton compte. Merci !
                </div>
                <div class="flex justify-center mb-5">
                    <button
                        class="btn btn-primary btn-sm"
                        @click="editEmail = true"
                    >
                        Utiliser un autre email
                    </button>
                </div>
                <div class="flex items-center justify-center gap-1">
                    <span class="text-lg text-gray-700">
                        Tu n'as pas reçu d'email ?
                    </span>
                    <Button
                        unstyled
                        label="Renvoyer"
                        :loading="form.processing"
                        class="text-lg font-medium link underline"
                        @click="submit"
                    />
                </div>
                <div
                    v-if="verificationLinkSent"
                    class="mt-4 font-medium text-sm text-green-600 text-center"
                >
                    Un nouveau lien de verification a été envoyé à ton adresse
                    email.
                </div>
            </div>
        </div>
    </AuthLayout>
</template>
