<script setup>
import { computed } from 'vue';

const props = defineProps({
    currentPage: {
        type: String,
        default: 'home'
    }
});

const navItems = [
    { name: 'home', label: 'Accueil', href: '/app/home' },
    { name: 'editor', label: 'Rédaction', href: '/app/editor' },
    { name: 'projects', label: 'Suivi', href: '/app/projects' },
    { name: 'profile', label: 'Profil', href: '/app/profile' }
];

const isActive = (page) => props.currentPage === page;
</script>

<template>
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="text-xl font-bold text-indigo-600">Agora IA</div>
                </div>
                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <a v-for="item in navItems" :key="item.name" :href="item.href" :class="[
                        isActive(item.name)
                            ? 'text-indigo-600 border-b-2 border-indigo-600'
                            : 'text-gray-700 hover:text-indigo-600',
                        'px-3 py-2 text-sm font-medium'
                    ]">
                        {{ item.label }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <div class="sm:hidden fixed bottom-0 left-0 right-0 bg-white shadow-lg border-t border-gray-200 z-50">
        <div class="flex justify-around">
            <a v-for="item in navItems" :key="item.name" :href="item.href" :class="[
                'flex flex-col items-center p-3',
                isActive(item.name) ? 'text-indigo-600' : 'text-gray-700'
            ]">
                <!-- Home Icon -->
                <svg v-if="item.name === 'home'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>

                <!-- Editor Icon -->
                <svg v-else-if="item.name === 'editor'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>

                <!-- Projects Icon -->
                <svg v-else-if="item.name === 'projects'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>

                <!-- Profile Icon -->
                <svg v-else-if="item.name === 'profile'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>

                <span class="text-xs mt-1">{{ item.label }}</span>
            </a>
        </div>
    </div>
</template>