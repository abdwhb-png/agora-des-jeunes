<script setup>
import { useForm } from "@inertiajs/vue3";
import { useToast } from "@/Components/ui/toast/use-toast";

const { toast } = useToast();

const form = useForm({
    nom: null,
    prenom: null,
    phone: null,
    email: null,
    message: null,
});

const submit = (event) => {
    event.preventDefault();

    form.post(route("contact.perform"), {
        preserveScroll: true,
        onSuccess: (page) => {
            // toast({
            //     title: "Message envoyé",
            //     description: page.props.flash.success,
            // });
            form.reset();
        },
    });
};
</script>

<template>
    <form
        @submit.prevent="submit"
        id="email-form"
        name="email-form"
        data-name="Formulaire de contact"
        class="contact-form"
        data-wf-page-id="67590e9b756ef477159aea52"
        data-wf-element-id="0c080f88-b2da-9dff-7128-806b0a286ffa"
        aria-label="Email Form"
    >
        <div class="form-field-wrapper">
            <label for="Last-Name" class="contact-form-field-level">Nom</label
            ><input
                class="form-text-field w-input"
                maxlength="256"
                v-model="form.nom"
                data-name="Nom de famille"
                placeholder="Nom de famille"
                type="text"
                id="Last-Name"
            />
            <InputError :message="form.errors.nom" class="mt-1" />
        </div>
        <article class="form-field-wrapper flex-form-block">
            <label for="First-Name" class="contact-form-field-level"
                >Prénom</label
            ><input
                class="form-text-field w-input"
                maxlength="256"
                v-model="form.prenom"
                data-name="Prénom"
                placeholder="Prénom"
                type="text"
                id="First-Name"
                required
            />
            <InputError :message="form.errors.prenom" class="mt-1" />
        </article>
        <div class="form-field-wrapper">
            <label for="email" class="contact-form-field-level">Email</label
            ><input
                class="form-text-field w-input"
                maxlength="256"
                v-model="form.email"
                data-name="Email"
                placeholder="Adresse Email"
                type="email"
                id="email"
                required
            />
            <InputError :message="form.errors.nom" class="mt-1" />
        </div>
        <div class="form-field-wrapper">
            <label for="Phone" class="contact-form-field-level">Téléphone</label
            ><input
                class="form-text-field w-input"
                maxlength="256"
                v-model="form.phone"
                data-name="Numéro de téléphone"
                placeholder="Numéro de téléphone"
                type="tel"
                id="Phone"
                required
            />
            <InputError :message="form.errors.phone" class="mt-1" />
        </div>
        <div
            id="w-node-_0c080f88-b2da-9dff-7128-806b0a287004-159aea52"
            class="form-field-wrapper"
        >
            <label for="Message" class="contact-form-field-level">Message</label
            ><textarea
                id="Message"
                v-model="form.message"
                maxlength="5000"
                data-name="Message"
                placeholder="Ecris ton message"
                class="form-text-field is-textarea w-input"
            ></textarea>
            <InputError :message="form.errors.message" class="mt-1" />
        </div>
        <div
            id="w-node-_0c080f88-b2da-9dff-7128-806b0a287006-159aea52"
            class="form-field-button"
        >
            <div v-if="form.recentlySuccessful" class="mb-3">
                <Message severity="success">
                    Nous avons bien reçu ton message.
                </Message>
            </div>
            <div v-else class="button-primary-wrapper">
                <Button
                    type="submit"
                    unstyled
                    class="button-primary is-contact-form w-button"
                    :loading="form.processing"
                    label="Envoyer le message"
                />
                <div
                    class="button-shadow"
                    style="
                        transform: translate3d(8px, 8px, 0px) scale3d(1, 1, 1)
                            rotateX(0deg) rotateY(0deg) rotateZ(0deg)
                            skew(0deg, 0deg);
                        transform-style: preserve-3d;
                    "
                ></div>
            </div>
        </div>
    </form>
</template>
