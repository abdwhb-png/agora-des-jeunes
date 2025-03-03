<script setup>
import { ref } from "vue";
import { dialogBreakpoints } from "@/utils/helpers";

defineProps({
    image: String,
    title: {
        type: String,
        default: "Panel de bord",
    },
    description: {
        type: String,
        default: "Créer et gérer.",
    },
    btnText: {
        type: String,
        default: "Ajouter",
    },
    createComponent: [Object, Function], // Accepte un composant Vue
});

const create = ref(false);
</script>

<template>
    <div class="card md:h-full">
        <div class="card-body flex flex-col place-content-center gap-5">
            <div v-if="image" class="flex justify-center">
                <img alt="image" class="max-h-[180px]" :src="image" />
            </div>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-3 text-center">
                    <h2 class="text-1.5xl font-semibold text-gray-900">
                        {{ title }}
                    </h2>
                    <p class="text-sm font-medium text-gray-700">
                        {{ description }}
                    </p>
                </div>
                <div class="flex justify-center">
                    <button class="btn btn-primary" @click="create = true">
                        {{ btnText }}
                    </button>

                    <Dialog
                        v-model:visible="create"
                        modal
                        maximizable=""
                        :header="'Nouvelle donnée de ' + title"
                        :style="{ width: '50rem' }"
                        :breakpoints="dialogBreakpoints"
                    >
                        <component
                            :is="createComponent"
                            @created="create = false"
                            @canceled="create = false"
                        />
                    </Dialog>
                </div>

                <!-- Slot -->
                <slot></slot>
                <!-- /Slot -->
            </div>
        </div>
    </div>
</template>
