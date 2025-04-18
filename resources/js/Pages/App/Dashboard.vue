<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { cvBuilderUrl } from "@/config/appInit";
import DashBottom from "./Partials/Dashboard/DashBottom.vue";
import SectionBorder from "@/Components/SectionBorder.vue";

const startAI = () => {
    // Logic to start AI interaction
    console.log("Starting AI interaction...");
};

const features = [
    {
        name: "Créer un CV",
        position: "left",
        color: "#ffd066",
        url: cvBuilderUrl,
    },
    {
        name: "Entreprendre",
        position: "right",
        color: "#71ec71",
        route: "entreprendre",
    },
    {
        name: "Créer un projet",
        position: "top",
        color: "#a8c8e8",
        route: "projets",
    },
    {
        name: "Etudes",
        position: "bottom",
        color: "#ff89c4",
        route: "entreprendre",
    },
    {
        name: "Se former",
        position: "bottom-left",
        color: "#ceb0ec",
        route: "formation",
    },
    {
        name: "Emploi",
        position: "bottom-right",
        color: "#ffccaa",
        route: "emploi",
    },
];

// Basic positioning logic (adjust values as needed for visual accuracy)
const getPositionClasses = (position: string) => {
    const baseClasses =
        "absolute text-center text-gray-700 dark:text-gray-300 font-medium text-sm";
    const transformCenter = "transform -translate-x-1/2 -translate-y-1/2"; // Center the item origin

    switch (position) {
        case "top":
            return `${baseClasses} top-[calc(50%-80px)] left-1/2 -translate-x-1/2 -translate-y-full`; // Adjusted for better top placement
        case "right":
            return `${baseClasses} top-1/2 left-[calc(50%+100px)] -translate-y-1/2 translate-x-0`; // Adjusted for better right placement
        case "bottom-right":
            return `${baseClasses} top-[calc(50%+70px)] left-[calc(50%+70px)] ${transformCenter}`;
        case "bottom":
            return `${baseClasses} top-[calc(50%+100px)] left-1/2 -translate-x-1/2 translate-y-0`; // Adjusted for better bottom placement
        case "bottom-left":
            return `${baseClasses} top-[calc(50%+70px)] left-[calc(50%-70px)] ${transformCenter}`;
        case "left":
            return `${baseClasses} top-1/2 left-[calc(50%-100px)] -translate-y-1/2 -translate-x-full`; // Adjusted for better left placement
        default:
            return baseClasses;
    }
};
</script>

<template>
    <MainLayout title="Tableau de bord">
        <div class="grid gap-5 lg:gap-7.5">
            <div class="bg-bottom bg-cover bg-no-repeat hero-bg relative"></div>
            <div
                class="flex flex-col items-center justify-center text-center px-4"
            >
                <!-- Title -->
                <h1
                    class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-900 mb-3"
                >
                    {{ $page.props.config.seo.slogan }}
                </h1>

                <!-- Subtitle -->
                <p class="text-lg text-gray-600 dark:text-gray-700 mb-12">
                    Des outils et ressources adaptés aux besoins des jeunes.
                </p>

                <!-- Central Icon and Circular Elements -->
                <div class="relative w-64 h-64 md:w-80 md:h-80 mb-16">
                    <!-- Increased size -->
                    <!-- Central Icon -->
                    <div
                        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
                    >
                        <!-- Ajout d'un background circulaire linéaire derrière l'image IA -->
                        <div class="ai-background"></div>
                        <img
                            @click="startAI"
                            src="/images/the-bot.png"
                            alt="Image de l'IA"
                            class="text-7xl md:text-8xl ai-animation cursor-pointer"
                        />
                    </div>

                    <!-- Circular Feature Items -->
                    <div
                        v-for="feature in features"
                        :key="feature.name"
                        :class="getPositionClasses(feature.position)"
                    >
                        <component
                            :is="feature.route ? Link : 'a'"
                            :href="
                                feature.route
                                    ? route(feature.route)
                                    : feature.url
                            "
                            prefetch
                        >
                            <Chip
                                :class="`border-2 border-gray-300 dark:border-gray-600`"
                                :style="{ backgroundColor: feature.color }"
                            >
                                {{ feature.name }}
                            </Chip>
                        </component>
                    </div>
                </div>
                <div>
                    <!-- Button -->
                    <Link href="#" class="btn btn-primary btn-lg mb-4">
                        Allons-y !
                    </Link>
                    <!-- Description -->
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Chosis une option ou clique sur le bouton ci-dessus.
                    </div>
                </div>
            </div>
            <SectionBorder />
            <DashBottom />
        </div>
    </MainLayout>
</template>

<style scoped>
.hero-bg {
    background-image: url("/static/media/images/2600x1200/bg-3.png");
}
.dark .hero-bg {
    background-image: url("/static/media/images/2600x1200/bg-3-dark.png");
}

/* Animation pour l'image de l'IA */
.ai-animation {
    animation: aiMove 3s ease-in-out;
    animation-iteration-count: infinite;
    animation-delay: 3s; /* Animation se produit pendant 3s toutes les 6s (3s pause + 3s animation) */
}

@keyframes aiMove {
    0% {
        transform: translateY(0) scale(1);
        filter: brightness(1);
    }
    25% {
        transform: translateY(-5px) scale(1.05);
        filter: brightness(1.1);
    }
    50% {
        transform: translateY(0) scale(1.1);
        filter: brightness(1.2);
    }
    75% {
        transform: translateY(5px) scale(1.05);
        filter: brightness(1.1);
    }
    100% {
        transform: translateY(0) scale(1);
        filter: brightness(1);
    }
}

/* Pour assurer un fonctionnement correct dans dark mode */
.dark .ai-animation {
    animation-name: aiMoveDark;
}

@keyframes aiMoveDark {
    0% {
        transform: translateY(0) scale(1);
        filter: brightness(1);
    }
    25% {
        transform: translateY(-5px) scale(1.05);
        filter: brightness(1.15);
    }
    50% {
        transform: translateY(0) scale(1.1);
        filter: brightness(1.3);
    }
    75% {
        transform: translateY(5px) scale(1.05);
        filter: brightness(1.15);
    }
    100% {
        transform: translateY(0) scale(1);
        filter: brightness(1);
    }
}

/* Ajout d'un effet de propagation radial pour le background circulaire */
.ai-background {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: radial-gradient(
        circle,
        rgba(255, 255, 255, 0.5),
        rgba(0, 0, 0, 0.1)
    );
    z-index: -1;
    animation: radialExpand 3s infinite ease-in-out;
}

@keyframes radialExpand {
    0% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.5);
        opacity: 0.5;
    }
    100% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }
}
</style>
