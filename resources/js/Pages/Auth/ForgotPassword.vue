<script setup>
import { useForm } from "@inertiajs/vue3";

defineProps({
    status: String,
});

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <Head title="Mot de passe oublié" />

    <AuthLayout>
        <div class="card max-w-[370px] w-full">
            <div class="card-header gap-1 border-0">
                <Link href="/" class="btn btn-sm btn-icon btn-light">
                    <i class="ki-filled ki-arrow-left"> </i>
                </Link>
                <h3
                    class="text-lg font-medium text-gray-900 capitalize flex-grow text-center"
                >
                    Mot de passe oublié
                </h3>
            </div>
            <form
                @submit.prevent="submit"
                class="card-body flex flex-col gap-5 p-10 pt-2"
                id="reset_password_enter_email_form"
            >
                <div class="text-center">
                    <span class="text-2sm text-gray-700">
                        Tu as oublié ton mot de passe ?
                        <br />
                        Pas de soucis. Entre ton email et nous allons t'envoyer
                        un lien de reinitialisation.
                    </span>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="form-label font-normal text-gray-900">
                        Email du compte
                    </label>
                    <input
                        class="input"
                        placeholder="Ecris ton email"
                        type="email"
                        v-model="form.email"
                    />
                    <InputError class="mt-1" :message="form.errors.email" />
                </div>
                <Message v-if="status" closable severity="success">
                    {{ status }}
                </Message>
                <Button
                    label="Continuer"
                    :loading="form.processing"
                    icon="ki-filled ki-black-right"
                    type="submit"
                    unstyled
                    class="btn btn-primary flex justify-center grow"
                />
            </form>
        </div>
    </AuthLayout>
</template>
