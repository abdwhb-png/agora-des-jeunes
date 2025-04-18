<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { Search } from 'lucide-vue-next';

interface City {
    id: number;
    departement_id: number;
    name: string;
    code: string | null;
    residents: any | null;
    quartiers: string[];
    created_at: string;
    updated_at: string;
}

const emit = defineEmits<{
    (e: 'update:city', value: string): void;
    (e: 'update:district', value: string): void;
    (e: 'next'): void;
}>();

const props = defineProps<{
    city: string;
    district: string;
    cities: City[];
}>();

const form = ref({
    cityName: props.city,
    district: props.district,
    citySearch: '',
    districtSearch: ''
});

// Filtrer les villes en fonction de la recherche
const filteredCities = computed(() => {
    const search = form.value.citySearch.toLowerCase();
    return props.cities.filter(city =>
        city.name.toLowerCase().includes(search)
    );
});

// Obtenir la ville sélectionnée
const selectedCity = computed(() => {
    return props.cities.find(city => city.name === form.value.cityName);
});

// Filtrer les quartiers en fonction de la recherche et de la ville sélectionnée
const filteredDistricts = computed(() => {
    if (!selectedCity.value) return [];
    const search = form.value.districtSearch.toLowerCase();
    return selectedCity.value.quartiers.filter(district =>
        district.toLowerCase().includes(search)
    );
});

// Reset le quartier quand la ville change
watch(() => form.value.cityName, () => {
    form.value.district = '';
    form.value.districtSearch = '';
});

const isValid = computed(() => {
    return form.value.cityName && form.value.district;
});

const handleSubmit = () => {
    if (!isValid.value) return;

    emit('update:city', form.value.cityName);
    emit('update:district', form.value.district);
    emit('next');
};
</script>

<template>
    <div class="flex flex-col items-center w-full max-w-md mx-auto p-6">
        <h2 class="text-2xl font-bold mb-8 text-gray-800">Où habites-tu ?</h2>

        <form @submit.prevent="handleSubmit" class="w-full space-y-6">
            <!-- Sélection de la ville -->
            <div class="space-y-2">
                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <Search class="h-5 w-5 text-gray-400" />
                    </div>
                    <input type="text" id="citySearch" v-model="form.citySearch" placeholder="Rechercher une ville..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-secondary-500 focus:ring-secondary-500 transition-colors duration-300" />
                </div>
                <div class="mt-2 max-h-48 overflow-y-auto rounded-xl border-2 border-gray-200" v-if="form.citySearch">
                    <button v-for="city in filteredCities" :key="city.id" type="button"
                        @click="form.cityName = city.name; form.citySearch = ''"
                        class="w-full px-4 py-2 text-left hover:bg-secondary-50 transition-colors duration-300"
                        :class="{ 'bg-secondary-50 text-secondary-600': form.cityName === city.name }">
                        {{ city.name }}
                    </button>
                </div>
                <div v-if="selectedCity" class="mt-2 px-4 py-2 bg-secondary-50 text-secondary-600 rounded-xl">
                    Ville sélectionnée : {{ form.cityName }}
                </div>
            </div>

            <!-- Sélection du quartier -->
            <div class="space-y-2" v-if="selectedCity">
                <label for="district" class="block text-sm font-medium text-gray-700">Quartier</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <Search class="h-5 w-5 text-gray-400" />
                    </div>
                    <input type="text" id="districtSearch" v-model="form.districtSearch"
                        placeholder="Rechercher ou saisir votre quartier..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-secondary-500 focus:ring-secondary-500 transition-colors duration-300"
                        @keydown.enter.prevent="
                            if (form.districtSearch && (!filteredDistricts.length || !form.district)) {
                            form.district = form.districtSearch;
                            form.districtSearch = '';
                        }
                            " />
                </div>
                <div v-if="selectedCity.quartiers.length === 0"
                    class="mt-2 px-4 py-2 bg-yellow-50 text-yellow-600 rounded-xl">
                    Saisissez le nom de votre quartier et appuyez sur Entrée pour valider.
                </div>
                <div v-else-if="form.districtSearch && !filteredDistricts.length"
                    class="mt-2 px-4 py-2 bg-yellow-50 text-yellow-600 rounded-xl flex flex-col gap-2">
                    <p>Aucun quartier ne correspond à votre recherche.</p>
                    <button type="button" @click="form.district = form.districtSearch; form.districtSearch = ''"
                        class="text-left text-secondary-600 hover:text-secondary-700 font-medium">
                        Cliquez ici ou appuyez sur Entrée pour utiliser "{{ form.districtSearch }}"
                    </button>
                </div>
                <div v-else-if="form.districtSearch && filteredDistricts.length > 0"
                    class="mt-2 max-h-48 overflow-y-auto rounded-xl border-2 border-gray-200">
                    <button v-for="district in filteredDistricts" :key="district" type="button"
                        @click="form.district = district; form.districtSearch = ''"
                        class="w-full px-4 py-2 text-left hover:bg-secondary-50 transition-colors duration-300"
                        :class="{ 'bg-secondary-50 text-secondary-600': form.district === district }">
                        {{ district }}
                    </button>
                </div>
                <div v-if="form.district" class="mt-2 px-4 py-2 bg-secondary-50 text-secondary-600 rounded-xl">
                    Quartier sélectionné : {{ form.district }}
                </div>
            </div>

            <button type="submit"
                class="w-full py-3 px-4 rounded-xl text-white font-medium transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                :class="[
                    isValid
                        ? 'bg-gradient-to-r from-secondary-500 to-secondary-600 hover:from-secondary-600 hover:to-secondary-700'
                        : 'bg-gray-300'
                ]" :disabled="!isValid">
                Continuer
            </button>
        </form>
    </div>
</template>