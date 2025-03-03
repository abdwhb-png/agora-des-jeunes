<script setup lang="ts">
import HomeLayout from "@/Layouts/HomeLayout.vue";
</script>

<template>
    <HomeLayout title="Erreur 404">
        <section class="section-error-page-main">
            <div class="section-inner error-page">
                <div class="padding-global">
                    <div class="container">
                        <div class="content-align-center">
                            <div class="margin-bottom margin-24px">
                                <div class="error-title-wrapper">
                                    <h1 class="error-page-title">4</h1>
                                    <div class="error-logo-wrapper">
                                        <img
                                            src="/cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677e1c9bac6dd991ac6d5915_error%20page%200%20logo.svg"
                                            loading="lazy"
                                            alt="Image d'erreur 404"
                                            class="error-image"
                                        />
                                    </div>
                                    <h1 class="error-page-title">4</h1>
                                </div>
                            </div>
                            <div class="margin-bottom margin-40px">
                                <div class="error-page-main-text">
                                    <div class="body-text-24px">
                                        Oups! Cette page n'existe pas.
                                    </div>
                                </div>
                            </div>
                            <div class="error-button-container">
                                <a
                                    data-wf--button-button-primary--variant="secondary"
                                    href="/"
                                    class="button-primary-wrapper w-inline-block"
                                    ><div
                                        class="button-shadow"
                                        style="
                                            transform: translate3d(
                                                    8px,
                                                    8px,
                                                    0px
                                                )
                                                scale3d(1, 1, 1) rotateX(0deg)
                                                rotateY(0deg) rotateZ(0deg)
                                                skew(0deg, 0deg);
                                            transform-style: preserve-3d;
                                        "
                                    ></div>
                                    <div
                                        class="button-primary w-variant-df11cfe8-fb95-3c5a-9007-0ea80cca3abb"
                                    >
                                        <div class="button-text-wrapper">
                                            <div class="button-text">
                                                Retourner à l'accueil
                                            </div>
                                            <div class="button-text is-behind">
                                                Retourner à l'accueil
                                            </div>
                                        </div>
                                    </div></a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </HomeLayout>
</template>
