<script setup>
import HomeLayout from "@/Layouts/HomeLayout.vue";
import FaqRepeater from "@/Components/Home/FaqRepeater.vue";

defineProps(["faqs", "search_url"]);
</script>

<template>
    <HomeLayout title="Foire Aux Questions">
        <template #header>
            <header class="section-features-hero">
                <div class="section-spacer">
                    <div class="section-container">
                        <div class="hero-background"></div>
                        <div class="feature-hero">
                            <div class="padding-global">
                                <div class="container">
                                    <div class="text-align-center">
                                        <div
                                            data-w-id="409187f8-0613-8ad7-c68c-3ad32ccae3df"
                                            style="
                                                transform: translate3d(
                                                        0px,
                                                        0px,
                                                        0px
                                                    )
                                                    scale3d(1, 1, 1)
                                                    rotateX(0deg) rotateY(0deg)
                                                    rotateZ(0deg)
                                                    skew(0deg, 0deg);
                                                opacity: 1;
                                                transform-style: preserve-3d;
                                            "
                                            class="margin-bottom margin-24px"
                                        >
                                            <h1 class="feature-hero-heading">
                                                Foire aux questions
                                                <span class="color-primary"
                                                    >FAQ</span
                                                >
                                            </h1>
                                        </div>
                                        <div
                                            data-w-id="fb7ccfd6-ef64-c408-99c1-c094dde36f7b"
                                            style="
                                                transform: translate3d(
                                                        0px,
                                                        0px,
                                                        0px
                                                    )
                                                    scale3d(1, 1, 1)
                                                    rotateX(0deg) rotateY(0deg)
                                                    rotateZ(0deg)
                                                    skew(0deg, 0deg);
                                                opacity: 1;
                                                transform-style: preserve-3d;
                                            "
                                            class="margin-bottom margin-80px"
                                        >
                                            <p>
                                                Bienvenue dans notre espace FAQ
                                                !
                                                <br />
                                                Tu trouveras ici les réponses
                                                aux questions les plus
                                                fréquentes sur
                                                {{ $page.props.app.name }} et
                                                ses services.
                                            </p>
                                        </div>
                                        <div class="feature-hero-image-wrapper">
                                            <v-lazy-image
                                                src="https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/6774d7c902256cce1040b646_Hero%20Shape.svg"
                                                loading="lazy"
                                                alt="Feature Hero Shape"
                                                class="feature-hero-shape"
                                            />
                                            <v-lazy-image
                                                src="https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677652337172d5876dc18fbc_Website%20Shape.svg"
                                                loading="lazy"
                                                alt="Feature Hero Shape"
                                                class="feature-hero-shape is-two"
                                            />
                                            <v-lazy-image
                                                class="feature-hero-main-image"
                                                src="/images/desola-lanre-ologun-kwzWjTnDPLk-unsplash.jpg"
                                                alt="Image foire aux questions"
                                                style="
                                                    transform: translate3d(
                                                            0px,
                                                            0px,
                                                            0px
                                                        )
                                                        scale3d(1, 1, 1)
                                                        rotateX(0deg)
                                                        rotateY(0deg)
                                                        rotateZ(0deg)
                                                        skew(0deg, 0deg);
                                                    opacity: 1;
                                                    transform-style: preserve-3d;
                                                "
                                                sizes="(max-width: 479px) 87vw, (max-width: 767px) 90vw, (max-width: 991px) 88vw, (max-width: 1279px) 100vw, 1140px"
                                                data-w-id="2ae7d9bc-0be9-dab5-bd80-8d86c5f49854"
                                                loading="eager"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </template>

        <FaqRepeater :data="faqs" :search-url="search_url" />
    </HomeLayout>
</template>
