<script setup>
import { computed, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { dialogBreakpoints } from "@/utils/helpers";
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";
import prompts from "@/config/prompts.json";
import AiButton from "@/Components/Base/AiButton.vue";

const PROMPT = prompts.project_description;
const page = usePage();
const create = ref(false);
const needDescForIa = ref(15);

const aiButton = ref(null);
const userInput = ref("");

const form = useForm({
    title: null,
    type: null,
    description: "",
});

const restDescForIa = computed(
    () => needDescForIa.value - form.description.length,
);

const completeDescription = (event) => {
    form.clearErrors();
    if (!form.title) {
        form.setError({ title: "Le titre est obligatoire" });
        return;
    }

    userInput.value = `${PROMPT.user}\n
    Titre du projet: ${form.title}\n
    Type de projet: ${form.type}\n
    Description: ${form.description}`;

    aiButton.value?.generate();
};

const store = () => {
    form.post(route(page.props.routePrefix + "projet.store"), {
        preserveScroll: true,
        onSuccess: () => {
            create.value = false;
        },
    });
};
</script>

<template>
    <div
        @click="create = true"
        class="border-2 border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:border-indigo-300 transition-colors duration-300 cursor-pointer"
    >
        <div
            class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-3"
        >
            <i
                class="ki-filled text-3xl me-4 ki-filled ki-plus-squared text-primary"
            ></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900">Nouveau projet</h3>
        <p class="mt-1 text-sm text-gray-500">
            Créer un nouveau projet avec l'aide de l'IA
        </p>
    </div>

    <Dialog
        v-model:visible="create"
        modal
        @hide="form.clearErrors()"
        :breakpoints="dialogBreakpoints"
        header="Nouveau projet"
    >
        <form @submit.prevent="store">
            <div class="grid md:grid-cols-2 mt-1.5 space-x-4">
                <div class="">
                    <InputError class="mb-2" :message="form.errors.title" />
                    <FloatLabel variant="on" class="mb-4">
                        <InputText
                            v-model="form.title"
                            id="project_title"
                            fluid
                            required
                        />
                        <label for="project_title">Titre du projet</label>
                    </FloatLabel>
                </div>

                <div>
                    <InputError class="mb-2" :message="form.errors.type" />
                    <FloatLabel variant="on" class="mb-4">
                        <InputText
                            v-model="form.type"
                            id="project_type"
                            fluid
                        />
                        <label for="project_type"
                            >Type de projet (facultatif)</label
                        >
                    </FloatLabel>
                </div>
            </div>

            <div>
                <FloatLabel variant="on" class="mb-4">
                    <Textarea
                        required
                        v-model="form.description"
                        id="project_description"
                        rows="7"
                        placeholder="
Parle un peu de ton projet pour que l'IA puisse t'aider...
Dit de quoi il s'agit, l'objectif du projet."
                        fluid
                    />
                    <label for="project_description">
                        Description du projet
                        <br />
                    </label>
                </FloatLabel>
                <InputError class="mb-1" :message="form.errors.description" />
                <p class="text-xs" v-show="restDescForIa > 0">
                    Encore
                    <span class="text-primary">{{ restDescForIa }}</span>
                    caractères restants pour la génération IA
                </p>
            </div>
            <AiButton
                ref="aiButton"
                btnText="Générer la description avec l'IA"
                :user-input="userInput"
                :system-prompt="PROMPT.system"
                :disabled="restDescForIa > 0"
                :severity="restDescForIa > 0 ? 'secondary' : 'help'"
                :can-click="false"
                @click.stop="completeDescription"
                @generated="form.description = $event"
            />
            <FormButtonGroup
                submit-label="Continuer"
                :form="form"
                @canceled="
                    form.reset();
                    create = false;
                "
            />
        </form>
    </Dialog>
</template>
