<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("password.update"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <Head title="Réinitialisation de mot de passe" />

    <AuthLayout>
        <div class="card max-w-[370px] w-full">
            <form
                @submit.prevent="submit"
                class="card-body flex flex-col gap-5 p-10"
                id="reset_password_change_password_form"
            >
                <div class="text-center">
                    <h3 class="text-lg font-medium text-gray-900">
                        Réinitialisation de mot de passe
                    </h3>
                    <span class="text-2sm text-gray-700">
                        Créez votre nouveau mot de passe
                    </span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="form-label text-gray-900"> Email </label>
                    <input
                        class="input"
                        placeholder="Ecris ton email actuel"
                        type="email"
                        v-model="form.email"
                    />
                    <InputError class="mt-1" :message="form.errors.email" />
                </div>
                <div class="flex flex-col gap-1">
                    <label class="form-label text-gray-900">
                        Nouveau mot de passe
                    </label>
                    <label class="input" data-toggle-password="true">
                        <input
                            name="user_new_password"
                            placeholder="Ecris le nouveau mot de passe"
                            type="password"
                            v-model="form.password"
                        />
                        <div
                            class="btn btn-icon"
                            data-toggle-password-trigger="true"
                        >
                            <i
                                class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"
                            >
                            </i>
                            <i
                                class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"
                            >
                            </i>
                        </div>
                    </label>
                    <InputError class="mt-1" :message="form.errors.password" />
                </div>
                <div class="flex flex-col gap-1">
                    <label class="form-label font-normal text-gray-900">
                        Confirmation du mot de passe
                    </label>
                    <label class="input" data-toggle-password="true">
                        <input
                            name="user_confirm_password"
                            placeholder="Confirme le nouveau mot de passe"
                            type="password"
                            v-model="form.password_confirmation"
                        />
                        <div
                            class="btn btn-icon"
                            data-toggle-password-trigger="true"
                        >
                            <i
                                class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden"
                            >
                            </i>
                            <i
                                class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block"
                            >
                            </i>
                        </div>
                    </label>
                    <InputError
                        class="mt-1"
                        :message="form.errors.password_confirmation"
                    />
                </div>
                <Button
                    label="Sauvegarder"
                    type="submit"
                    :loading="form.processing"
                    unstyled
                    class="btn btn-primary flex justify-center grow"
                />
            </form>
        </div>
    </AuthLayout>
</template>
