<template>
    <div class="card">
        <div class="card-header" id="delete_account">
            <h3 class="card-title">Désactiver le compte</h3>
        </div>
        <div class="card-body flex flex-col lg:py-7.5 lg:gap-7.5 gap-3">
            <div class="flex flex-col gap-5">
                <div class="text-2sm text-gray-800">
                    Au lieu de supprimer définitivement ton compte, tu peux
                    simplement le désactiver et le réactiver plus tard.
                </div>
            </div>
            <div class="flex justify-end gap-2.5">
                <Button
                    label="Désactiver temporairement"
                    unstyled
                    :loading="form.processing && form.action == 'deactivate'"
                    class="btn btn-danger btn-outline"
                    @click="confirmUserDeletion('deactivate')"
                />
                <button
                    :loading="form.processing && form.action == 'deactivate'"
                    class="btn btn-danger"
                    @click="confirmUserDeletion('delete')"
                >
                    Supprimer définitivement
                </button>
            </div>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <DialogModal :show="confirmingUserDeletion" @close="closeModal">
            <template #title>
                {{
                    form.action == "delete"
                        ? "Supprimer mon compte"
                        : "Désactiver mon copte"
                }}
            </template>

            <template #content>
                <p>Nous regrettons de te voir partir.</p>
                <p>Entre ton mot de passe pour confirmer ton action action.</p>
                <br />
                <p>
                    {{
                        form.action == "delete"
                            ? "Sache qu'une fois ton compte supprimé, toutes ses ressources et ses données seront définitivement perdues."
                            : "Tu pourras réactiver votre compte plus tard."
                    }}
                </p>
                <p v-if="form.action == 'delete'" class="text-danger">
                    Cette action est irréversible !
                </p>

                <div class="mt-4" v-focustrap>
                    <FloatLabel variant="on">
                        <Password
                            v-model="form.password"
                            toggleMask
                            :autofocus="true"
                        />
                        <label for="password">Mot de passe</label>
                    </FloatLabel>

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <div class="flex justify-end gap-4">
                    <button
                        class="btn btn-light"
                        :disabled="form.processing"
                        @click="closeModal"
                    >
                        Annuler
                    </button>

                    <Button
                        :loading="form.processing"
                        severity="info"
                        label="Confirmer mon action"
                        class="btn btn-danger"
                        @click="deleteUser"
                    />
                </div>
            </template>
        </DialogModal>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import DialogModal from "@/Components/DialogModal.vue";

const confirmingUserDeletion = ref(false);

const form = useForm({
    password: "",
    action: null,
});

const confirmUserDeletion = (type) => {
    form.action = type;
    confirmingUserDeletion.value = true;
};

const deleteUser = () => {
    form.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onStart: () => {
            if (form.action == "delete") {
                form.cancel();
            }
        },
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
        onCancel: () => {
            alert("Veuillez contacter le support pour désactiver votre compte");
            closeModal();
        },
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>
