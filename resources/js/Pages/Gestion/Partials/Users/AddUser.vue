<template>
    <div class="flex flex-col gap-7.5">
        <div class="flex justify-center">
            <Card v-if="$page.props.can.createUser" class="min-w-[400px]">
                <template #title>Invité un utilisateur</template>
                <template #content>
                    <form @submit.prevent="submit" class="flex flex-col gap-5">
                        <div>
                            <FloatLabel variant="on">
                                <InputText
                                    v-model="form.name"
                                    id="name"
                                    required
                                    fluid
                                    size="large"
                                />
                                <label for="name">Nom</label>
                            </FloatLabel>
                            <InputError
                                class="mt-1"
                                :message="form.errors.name"
                            />
                        </div>
                        <div>
                            <FloatLabel variant="on">
                                <InputText
                                    v-model="form.email"
                                    id="email"
                                    type="email"
                                    required
                                    fluid
                                    size="large"
                                />
                                <label for="email">Email</label>
                            </FloatLabel>
                            <InputError
                                class="mt-1"
                                :message="form.errors.email"
                            />
                        </div>

                        <div>
                            <FloatLabel variant="on">
                                <Select
                                    v-model="form.role"
                                    id="role"
                                    :options="roles"
                                    option-label="label"
                                    option-value="value"
                                    required
                                    fluid
                                />
                                <label for="role">Role</label>
                            </FloatLabel>
                            <InputError
                                class="mt-1"
                                :message="form.errors.email"
                            />
                        </div>

                        <Message
                            severity="info"
                            closable
                            v-if="form.wasSuccessful"
                            >Lien envoyé. La personne doit accepter
                            l'invitation.</Message
                        >
                        <Button
                            type="submit"
                            label="Envoyé l'invitation"
                            :loading="form.processing"
                        ></Button>
                    </form>
                </template>
            </Card>

            <Message severity="warning" v-else
                >Vous n'avez pas les permissions pour ajouter des
                utilisateurs</Message
            >
        </div>

        <InvitationsList :data="$page.props.users_invitations" />
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { useToast } from "primevue";
import InvitationsList from "./InvitationsList.vue";

const toast = useToast();

const roles = [
    { label: "Membre", value: "user" },
    { label: "Gestionnaire", value: "admin" },
];

const form = useForm({
    name: null,
    email: null,
    role: null,
});

const submit = () => {
    form.post(route("user.invite"), {
        preserveScroll: true,
        onSuccess: (page) => {
            form.reset();

            toast.add({
                severity: "success",
                summary: page.props.flash.success,
                life: 5000,
            });
        },
    });
};
</script>
