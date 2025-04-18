<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const title = "Agora IA - Assistant d'écriture et suivi de projet";
</script>

<template>

    <Head :title="title" />
    <div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50">
        <!-- Navigation Bar -->
        <nav class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="text-xl font-bold text-indigo-600">Agora IA</div>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:space-x-8">
                        <a href="#"
                            class="text-indigo-600 border-b-2 border-indigo-600 px-3 py-2 text-sm font-medium">Accueil</a>
                        <a href="#"
                            class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Rédaction</a>
                        <a href="#" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Suivi</a>
                        <a href="#" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Profil</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="pt-32 pb-12 md:pt-40 md:pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                        La meilleure façon de réussir tes projets !
                    </h1>
                    <p class="mt-5 text-xl text-gray-500">
                        Rédige et organise tes projets avec l'aide de l'intelligence artificielle.
                    </p>
                    <div class="mt-8 flex justify-center">
                        <PrimaryButton class="px-8 py-3 text-base">
                            Let's go !
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">Des outils puissants pour tes projets</h2>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                        Tout connaître par cœur n'aura jamais été aussi simple.
                    </p>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Feature 1: Coach IA -->
                        <div
                            class="flex flex-col items-center p-6 bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl shadow-sm">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Coach IA</h3>
                            <p class="mt-2 text-base text-gray-500 text-center">
                                Choisis le coach IA qui t'aidera et te motivera dans ton parcours d'apprentissage.
                            </p>
                        </div>

                        <!-- Feature 2: Cartes Mémos -->
                        <div
                            class="flex flex-col items-center p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow-sm">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Cartes mémos</h3>
                            <p class="mt-2 text-base text-gray-500 text-center">
                                Retiens l'essentiel avec les cartes mémos générées automatiquement.
                            </p>
                        </div>

                        <!-- Feature 3: QCM -->
                        <div
                            class="flex flex-col items-center p-6 bg-gradient-to-br from-orange-50 to-red-50 rounded-xl shadow-sm">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100 text-orange-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">QCM</h3>
                            <p class="mt-2 text-base text-gray-500 text-center">
                                Booste ta mémoire avec des QCM quotidiens adaptés à ton niveau.
                            </p>
                        </div>

                        <!-- Feature 4: Fiches de révision -->
                        <div
                            class="flex flex-col items-center p-6 bg-gradient-to-br from-fuchsia-50 to-purple-50 rounded-xl shadow-sm">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-fuchsia-100 text-fuchsia-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Fiches de révision</h3>
                            <p class="mt-2 text-base text-gray-500 text-center">
                                Génère tes fiches de révision en 3 secondes grâce à l'IA.
                            </p>
                        </div>

                        <!-- Feature 5: Quiz adaptés -->
                        <div
                            class="flex flex-col items-center p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-sm">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Quiz adaptés</h3>
                            <p class="mt-2 text-base text-gray-500 text-center">
                                Des quiz qui s'adaptent à ton niveau pour une progression constante.
                            </p>
                        </div>

                        <!-- Feature 6: Enregistrement vocal -->
                        <div
                            class="flex flex-col items-center p-6 bg-gradient-to-br from-violet-50 to-purple-50 rounded-xl shadow-sm">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-violet-100 text-violet-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Enregistrement vocal</h3>
                            <p class="mt-2 text-base text-gray-500 text-center">
                                Explique tes idées à voix haute et l'IA organisera tes pensées.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Section -->
        <div class="py-16 bg-indigo-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-6 md:mb-0 md:w-2/3">
                        <h2 class="text-2xl font-bold text-white">Prêt à améliorer ta façon d'apprendre ?</h2>
                        <p class="mt-3 text-lg text-indigo-100">
                            Commence dès maintenant et vois ta progression s'améliorer jour après jour.
                        </p>
                    </div>
                    <div class="md:w-1/3 md:text-right">
                        <PrimaryButton
                            class="w-full md:w-auto px-8 py-3 text-base bg-white text-indigo-600 hover:bg-indigo-50">
                            Commencer
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Bottom Navigation -->
        <div class="sm:hidden fixed bottom-0 left-0 right-0 bg-white shadow-lg border-t border-gray-200">
            <div class="flex justify-around">
                <a href="#" class="flex flex-col items-center p-3 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-xs mt-1">Accueil</span>
                </a>
                <a href="#" class="flex flex-col items-center p-3 text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span class="text-xs mt-1">Rédaction</span>
                </a>
                <a href="#" class="flex flex-col items-center p-3 text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="text-xs mt-1">Suivi</span>
                </a>
                <a href="#" class="flex flex-col items-center p-3 text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-xs mt-1">Profil</span>
                </a>
            </div>
        </div>
    </div>
</template>