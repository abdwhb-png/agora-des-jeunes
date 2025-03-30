<script setup>
const items = [
    {
        key: 1,
        title: "Inscription",
        description:
            "Inscris-toi gratuitement en quelques secondes et remplis les informations requises.",
    },
    {
        key: 2,
        title: "Exploration",
        description:
            "Accède à toutes les fonctionnalités et commence à explorer.",
    },
    {
        key: 3,
        title: "Passe à l'action",
        description:
            "Développe tes compétences et tes opportunités grâce à notre IA et nos experts.",
    },
];
</script>

<template>
    <section class="section-process" id="how-it-works">
        <div class="padding-global mt-20">
            <div class="container">
                <div class="w-layout-grid process-grid">
                    <div class="process-col">
                        <div
                            data-w-id="169cf9ac-5d68-94c5-027e-8271b37e4b85"
                            class="margin-bottom margin-24px set-animation"
                        >
                            <div
                                data-wf--ui-section-subtitle--variant="base"
                                class="section-subtitle-wrapper"
                            >
                                <SubtitleIcon class="section-subtitle-icon" />
                                <p class="section-subtitle">
                                    Comment ça marche ?
                                </p>
                            </div>
                        </div>
                        <h2
                            data-w-id="169cf9ac-5d68-94c5-027e-8271b37e4b86"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                transform-style: preserve-3d;
                                opacity: 1;
                            "
                        >
                            <span class="color-primary"
                                >Disponible pour tous</span
                            >, facile rapide et accessible !
                        </h2>
                    </div>
                    <div class="process-item-wrapper">
                        <div
                            v-for="item in items"
                            :key="item.title"
                            class="process-item"
                        >
                            <div class="process-item-count">
                                Etape {{ item.key }}
                            </div>
                            <div class="process-item-content">
                                <div class="margin-bottom margin-16px">
                                    <h3 class="heading-custom-h5">
                                        {{ item.title }}
                                    </h3>
                                </div>
                                <p>
                                    {{ item.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-padding-regular"></div>
                <div class="section-border"></div>
            </div>
        </div>
    </section>
</template>
