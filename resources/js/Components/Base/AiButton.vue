<template>
    <Button
        size="small"
        :severity="severity"
        outlined
        :loading="loading"
        @click="canClick && generate"
    >
        <Loader2 v-if="loading" class="animate-spin" />
        <Brain v-else />
        {{ btnText }}
    </Button>
</template>

<script setup>
import { useGroq } from "@/composables/useGroq";
import { useToast } from "primevue";
import { ref } from "vue";
import { Brain, Loader2 } from "lucide-vue-next";

const emits = defineEmits(["clicked", "generated"]);

const props = defineProps({
    btnText: { type: String, default: "Générer avec l'IA" },
    severity: { type: String, default: "help" },
    userInput: { type: String, required: true },
    systemPrompt: { type: String, default: "" },
    canClick: { type: Boolean, default: true },
});

const toast = useToast();
const loading = ref(false);

function generate() {
    if (!props.userInput) return; // 🔹 Empêche la génération si `userInput` est vide
    loading.value = true;

    const { mainChat } = useGroq();

    mainChat(props.userInput, props.systemPrompt)
        .then((response) => {
            if (response.success) {
                emits("generated", response.output);
            } else {
                toast.add({
                    summary: "La génération par l'IA a échoué.",
                    detail: response.output,
                    severity: "contrast",
                    life: 5000,
                });
            }
        })
        .finally(() => {
            loading.value = false;
        });
}

// ✅ Expose `generate` après sa définition
defineExpose({ generate });
</script>
