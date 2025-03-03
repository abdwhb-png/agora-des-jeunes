<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const emits = defineEmits(["updated"]);

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: "PUT",
    email: props.user?.email,
});

const verificationLinkSent = ref(null);

const updateProfileInformation = () => {
    form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => {
            emits("updated");
        },
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title> Adresse Email </template>

        <template #description> Met à jour ton adresse email. </template>

        <template #form>
            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError :message="form.errors.email" class="mt-2" />

                <div
                    v-if="
                        $page.props.jetstream.hasEmailVerification &&
                        user.email_verified_at === null
                    "
                >
                    <p class="text-sm mt-2">
                        Ton email n'est pas encore verifié.

                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click.prevent="sendEmailVerification"
                        >
                            Renvoyer le lien de vérification.
                        </Link>
                    </p>

                    <div
                        v-show="verificationLinkSent"
                        class="mt-2 font-medium text-sm text-green-600"
                    >
                        A new verification link has been sent to your email
                        address.
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Email mis à jour.
            </ActionMessage>

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Mettre à jour
            </PrimaryButton>
        </template>
    </FormSection>
</template>
