<script setup lang="ts">
import { ref, computed } from 'vue';

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
    (e: 'next'): void;
}>();

const props = defineProps<{
    modelValue: string;
}>();

const form = ref({
    day: '',
    month: '',
    year: ''
});

// Initialiser les champs si modelValue existe
if (props.modelValue) {
    const [year, month, day] = props.modelValue.split('-');
    form.value = {
        year,
        month,
        day
    };
}

const days = Array.from({ length: 31 }, (_, i) => i + 1);
const months = Array.from({ length: 12 }, (_, i) => i + 1);
const currentYear = new Date().getFullYear();
const years = Array.from({ length: 100 }, (_, i) => currentYear - i);

const isValid = computed(() => {
    return form.value.day && form.value.month && form.value.year;
});

const handleSubmit = () => {
    if (!isValid.value) return;

    const date = `${form.value.year}-${form.value.month.toString().padStart(2, '0')}-${form.value.day.toString().padStart(2, '0')}`;
    emit('update:modelValue', date);
    emit('next');
};
</script>

<template>
    <div class="flex flex-col items-center w-full max-w-md mx-auto p-6">
        <h2 class="text-2xl font-bold mb-8 text-gray-800">Quelle est ta date de naissance ?</h2>

        <form @submit.prevent="handleSubmit" class="w-full space-y-6">
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="day" class="block text-sm font-medium text-gray-700 mb-1">Jour</label>
                    <select id="day" v-model="form.day"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-secondary-500 focus:ring-secondary-500 transition-colors duration-300"
                        :class="{ 'border-secondary-500 bg-secondary-50': form.day }">
                        <option value="">Jour</option>
                        <option v-for="day in days" :key="day" :value="day">
                            {{ day }}
                        </option>
                    </select>
                </div>

                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Mois</label>
                    <select id="month" v-model="form.month"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-secondary-500 focus:ring-secondary-500 transition-colors duration-300"
                        :class="{ 'border-secondary-500 bg-secondary-50': form.month }">
                        <option value="">Mois</option>
                        <option v-for="month in months" :key="month" :value="month">
                            {{ month }}
                        </option>
                    </select>
                </div>

                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                    <select id="year" v-model="form.year"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-secondary-500 focus:ring-secondary-500 transition-colors duration-300"
                        :class="{ 'border-secondary-500 bg-secondary-50': form.year }">
                        <option value="">Année</option>
                        <option v-for="year in years" :key="year" :value="year">
                            {{ year }}
                        </option>
                    </select>
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