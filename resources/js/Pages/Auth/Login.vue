<script setup>
import { useForm } from "@inertiajs/vue3";
import SocialAuth from "@/Components/Base/SocialAuth.vue";

const props = defineProps({
    canResetPassword: Boolean,
    defaultEmail: String,
    status: String,
});

const form = useForm({
    email: props.defaultEmail || "",
    password: props.defaultEmail ? "password" : "",
    remember: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onStart: () => form.clearErrors(),
        onSuccess: () => {
            // axios.get("/sanctum/csrf-cookie");
        },
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Connexion" />
    <AuthLayout :branded="true">
        <template #form>
            <div class="card max-w-[370px] w-full">
                <form
                    @submit.prevent="submit"
                    class="card-body flex flex-col gap-5 p-10"
                    id="sign_in_form"
                >
                    <div class="text-center mb-2.5">
                        <h3
                            class="text-lg font-medium text-gray-900 leading-none"
                        >
                            Connexion
                        </h3>
                    </div>

                    <SocialAuth v-if="$page.props.socialAuth?.length" />

                    <div class="flex flex-col gap-1">
                        <label class="form-label font-normal text-gray-900">
                            Email
                        </label>
                        <input
                            class="input"
                            placeholder="Entre ton email"
                            type="text"
                            v-model="form.email"
                        />
                        <InputError class="mt-1" :message="form.errors.email" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center justify-between gap-1">
                            <label class="form-label font-normal text-gray-900">
                                Mot de Passe
                            </label>
                            <Link
                                class="text-2sm link shrink-0"
                                v-if="canResetPassword"
                                :href="route('password.request')"
                            >
                                Mot de Passe oublié?
                            </Link>
                        </div>
                        <div
                            class="input"
                            data-toggle-password="true"
                            data-toggle-password-permanent="true"
                        >
                            <input
                                name="user_password"
                                placeholder="Entre ton mot de passe"
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
                    <label class="checkbox-group">
                        <input
                            class="checkbox checkbox-sm"
                            name="remember"
                            type="checkbox"
                            v-model="form.remember"
                            y
                        />
                        <span class="checkbox-label"> Se souvenir de moi </span>
                    </label>
                    <Button
                        type="submit"
                        label="Se connecter"
                        :loading="form.processing"
                        unstyled
                        class="btn btn-primary flex justify-center grow"
                    />

                    <div
                        v-if="route().has('register')"
                        class="flex items-center justify-center font-medium"
                    >
                        <span class="text-2sm text-gray-700 me-1.5">
                            Besoin d'un compte?
                        </span>
                        <Link
                            class="text-2sm link underline"
                            :href="route('register')"
                        >
                            Inscris-toi
                        </Link>
                    </div>
                </form>
            </div>
        </template>
    </AuthLayout>
</template>
