<script setup>
import { ref, onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import SocialAuth from "@/Components/Base/SocialAuth.vue";

const props = defineProps({
    invitationError: String,
    invitation: Object,
});

const form = useForm({
    email: props.invitation?.email || null,
    phone: null,
    password: "",
    password_confirmation: "",
    terms: false,
    invitation_id: props.invitation?.id || null,
});

const submit = () => {
    form.post(route("register"), {
        onStart: () => form.clearErrors(),
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Inscription" />
    <AuthLayout :branded="true">
        <template #form>
            <div class="card max-w-[370px] w-full">
                <form
                    @submit.prevent="submit"
                    class="card-body flex flex-col gap-5 p-10"
                    id="sign_up_form"
                >
                    <div class="text-center mb-2.5">
                        <h3
                            class="text-lg font-medium text-gray-900 leading-none"
                        >
                            Inscription
                        </h3>
                    </div>

                    <SocialAuth v-if="$page.props.socialAuth?.length" />

                    <div class="flex flex-col gap-1">
                        <label class="form-label text-gray-900"> Email </label>
                        <input
                            class="input"
                            name="user_email"
                            placeholder="Ecris ton email"
                            type="email"
                            autofocus
                            v-model="form.email"
                        />
                        <InputError class="mt-1" :message="form.errors.email" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="form-label text-gray-900">
                            Numéro de téléphone
                        </label>
                        <input
                            class="input"
                            name="user_phone"
                            placeholder="Ecris ton numéro de téléphone"
                            type="text"
                            v-model="form.phone"
                        />
                        <InputError class="mt-1" :message="form.errors.phone" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="form-label font-normal text-gray-900">
                            Mot de passe
                        </label>
                        <div
                            class="input"
                            data-toggle-password="true"
                            data-toggle-password-permanent="true"
                        >
                            <input
                                name="user_password"
                                placeholder="Crée ton mot de passe"
                                type="password"
                                v-model="form.password"
                            />
                            <button
                                class="btn btn-icon"
                                data-toggle-password-trigger="true"
                                type="button"
                            >
                                <i
                                    class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"
                                >
                                </i>
                                <i
                                    class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"
                                >
                                </i>
                            </button>
                        </div>
                        <InputError
                            class="mt-1"
                            :message="form.errors.password"
                        />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="form-label font-normal text-gray-900">
                            Confirmation de mot de passe
                        </label>
                        <div
                            class="input"
                            data-toggle-password="true"
                            data-toggle-password-permanent="true"
                        >
                            <input
                                name="user_password"
                                placeholder="Ecris à nouveau le mot de passe"
                                type="password"
                                v-model="form.password_confirmation"
                            />
                            <button
                                class="btn btn-icon"
                                data-toggle-password-trigger="true"
                                type="button"
                            >
                                <i
                                    class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"
                                >
                                </i>
                                <i
                                    class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"
                                >
                                </i>
                            </button>
                        </div>
                        <InputError
                            class="mt-1"
                            :message="form.errors.password_confirmation"
                        />
                    </div>
                    <label
                        v-if="
                            $page.props.jetstream
                                .hasTermsAndPrivacyPolicyFeature
                        "
                        class="checkbox-group"
                    >
                        <input
                            class="checkbox checkbox-sm"
                            name="terms"
                            type="checkbox"
                            v-model="form.terms"
                            required
                        />
                        <span class="checkbox-label">
                            J'accepte les
                            <Link
                                class="text-2sm link"
                                target="_blank"
                                :href="route('terms.show')"
                            >
                                conditions d'utilisation
                            </Link>
                            et
                            <Link
                                class="text-2sm link"
                                target="_blank"
                                :href="route('policy.show')"
                            >
                                politique de confidentialité
                            </Link>
                        </span>
                    </label>
                    <Button
                        type="submit"
                        label="S'inscrire"
                        :loading="form.processing"
                        unstyled
                        class="btn btn-primary flex justify-center grow"
                    />

                    <div class="flex items-center justify-center">
                        <span class="text-2sm text-gray-700 me-1.5">
                            Déjà inscrit ?
                        </span>
                        <Link
                            class="text-2sm link underline"
                            :href="route('login')"
                        >
                            Connecte-toi
                        </Link>
                    </div>
                </form>
            </div>
        </template>
    </AuthLayout>
</template>
