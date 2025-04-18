<script setup lang="ts">
import { ref, computed, watch, onMounted } from 'vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { useLocalStorage } from '@vueuse/core';
import Logo from '@/Components/Logo.vue';
import GenderStep from './Partials/OnBoarding/GenderStep.vue';
import NameStep from './Partials/OnBoarding/NameStep.vue';
import BirthDateStep from './Partials/OnBoarding/BirthDateStep.vue';
import OccupationStep from './Partials/OnBoarding/OccupationStep.vue';
import LocationStep from './Partials/OnBoarding/LocationStep.vue';
import InterestsStep from './Partials/OnBoarding/InterestsStep.vue';
import Toaster from "@/Components/ui/toast/Toaster.vue";
import { ChevronLeft, PowerOff } from 'lucide-vue-next';
import { useToast } from "@/Components/ui/toast/use-toast";

const props = defineProps({
    cities: {
        type: Array,
        required: true
    }
});

const user = usePage().props.auth.user;
const { toast } = useToast();

// Stockage de la progression
const currentStep = useLocalStorage('onboarding-step', 1);
const totalSteps = 6;

// Stockage des données du formulaire
const storedFormData = useLocalStorage('onboarding-form-data', {
    sexe: user.info.sexe || '',
    prenom: user.info.prenom || '',
    nom: user.info.nom || '',
    date_naissance: user.info.date_naissance || '',
    profession: user.info.profession || '',
    ville: user.info.ville || '',
    quartier: user.info.quartier || '',
    interests: user.account.interests || [] as string[]
});

const form = useForm(storedFormData.value);

// Mettre à jour le stockage local quand le formulaire change
watch(() => form.data(), (newData) => {
    storedFormData.value = newData;
}, { deep: true });

const districts = computed(() => {
    return props.cities.reduce((acc, city) => {
        acc[city.name] = city.quartiers;
        return acc;
    }, {});
});

const progress = computed(() => {
    return (currentStep.value / totalSteps) * 100;
});

const goToNextStep = () => {
    if (currentStep.value < totalSteps) {
        currentStep.value++;
    } else {
        submitForm();
    }
};

const goToPreviousStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

const submitForm = async () => {
    form.put(route('user.info.update', user.id), {
        onSuccess: (page) => {
            toast({
                title: 'Informations enregistrées',
                description: page.props.flash.success,
            })
            router.visit(route('dashboard'));
        },
        onFinish: () => {
            // Nettoyer le stockage local après soumission réussie
            localStorage.removeItem('onboarding-step');
            localStorage.removeItem('onboarding-form-data');
        }
    });
};

// Restaurer la dernière étape si l'utilisateur revient
onMounted(() => {
    const savedStep = localStorage.getItem('onboarding-step');
    if (savedStep) {
        currentStep.value = parseInt(savedStep);
    }
});
</script>

<template>
    <Head title="Commencement" />
    <Toaster />
    <ToastError :errors="$page.props.errors" />
    <div class="min-h-screen bg-gradient-to-br from-primary-50 to-white">
        <!-- Header -->
        <header class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-sm py-4">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center">
                    <!-- Back button -->
                    <button v-if="currentStep > 1" @click="goToPreviousStep"
                        class="text-gray-600 hover:text-secondary-600 transition-colors duration-300">
                        <ChevronLeft :size="30" />
                    </button>
                    <div v-else class="w-[30px]"></div>
                    <Logo class="w-24 text-gray-600 hover:text-secondary-600 transition-colors duration-300" />
                    <UiButton variant="outline" size="icon" @click="router.post(route('logout'))">
                        <PowerOff class="text-red-500" />
                    </UiButton>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 pt-24">
            <!-- Progress bar -->
            <div class="w-full max-w-md mx-auto mb-8">
                <div class="relative pt-1">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <span class="text-xs font-semibold inline-block text-secondary-600">
                                Étape {{ currentStep }} sur {{ totalSteps }}
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-semibold inline-block text-secondary-600">
                                {{ Math.round(progress) }}%
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-secondary-100">
                        <div :style="{ width: `${progress}%` }"
                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-secondary-500 to-tertiary-600 transition-all duration-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Steps -->
            <Transition mode="out-in" enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 translate-x-8" enter-to-class="opacity-100 translate-x-0"
                leave-active-class="transition-all duration-300 ease-in" leave-from-class="opacity-100 translate-x-0"
                leave-to-class="opacity-0 -translate-x-8">
                <div :key="currentStep" class="flex justify-center items-center min-h-[calc(100vh-12rem)]">
                    <GenderStep v-if="currentStep === 1" v-model="form.sexe" @next="goToNextStep" />

                    <NameStep v-else-if="currentStep === 2" v-model:firstName="form.prenom" v-model:lastName="form.nom"
                        @next="goToNextStep" />

                    <BirthDateStep v-else-if="currentStep === 3" v-model="form.date_naissance" @next="goToNextStep" />

                    <OccupationStep v-else-if="currentStep === 4" v-model="form.profession" @next="goToNextStep" />

                    <LocationStep v-else-if="currentStep === 5" v-model:city="form.ville"
                        v-model:district="form.quartier" :cities="cities" :districts="districts" @next="goToNextStep" />

                    <InterestsStep v-else-if="currentStep === 6" v-model="form.interests" @next="goToNextStep" />
                </div>
            </Transition>
        </main>
    </div>
</template>

<style scoped>
.container {
    width: 100%;
    max-width: 1280px;
}
</style>