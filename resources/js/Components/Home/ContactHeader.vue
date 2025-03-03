<script setup>
import ContactForm from "./ContactForm.vue";
</script>

<template>
    <header class="section-contact-hero">
        <div class="section-spacer">
            <div class="section-container">
                <div class="hero-background is-contact"></div>
                <div class="hero-section-padding is-contact">
                    <div class="container">
                        <div class="text-align-center">
                            <div class="margin-bottom margin-24px">
                                <h1
                                    data-w-id="10d02637-ab6b-a8d7-c7a6-787e26b3c026"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        opacity: 1;
                                        transform-style: preserve-3d;
                                    "
                                >
                                    Nous sommes là
                                    <span class="color-primary">pour toi</span>
                                    !
                                </h1>
                            </div>
                            <div class="margin-bottom margin-80px">
                                <div class="contact-hero-info">
                                    <p
                                        data-w-id="10d02637-ab6b-a8d7-c7a6-787e26b3c02c"
                                        style="
                                            transform: translate3d(
                                                    0px,
                                                    0px,
                                                    0px
                                                )
                                                scale3d(1, 1, 1) rotateX(0deg)
                                                rotateY(0deg) rotateZ(0deg)
                                                skew(0deg, 0deg);
                                            opacity: 1;
                                            transform-style: preserve-3d;
                                        "
                                        class="body-text-18px"
                                    >
                                        Une question ? Une suggestion ?
                                        <br />
                                        Remplis le formulaire suivant et nous te
                                        répondrons dans les plus brefs délais.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="contact-hero-main">
                            <div
                                data-w-id="d345c4e9-3b27-3ee9-1da0-d0604c8900be"
                                class="contact-hero-thumb-block"
                            >
                                <v-lazy-image
                                    src="/images/customer-service.jpg"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        transform-style: preserve-3d;
                                    "
                                    alt="image de la page de contact"
                                    class="image-cover"
                                />
                                <div
                                    data-w-id="0389eb19-7d1b-b405-6e64-36f3dbd75ca2"
                                    style="
                                        transform: translate3d(0px, -110%, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        transform-style: preserve-3d;
                                    "
                                    class="image-animated-overlay"
                                ></div>
                            </div>
                            <div class="contact-hero-form-block">
                                <div
                                    data-w-id="0c080f88-b2da-9dff-7128-806b0a286ff9"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        opacity: 1;
                                        transform-style: preserve-3d;
                                    "
                                    class="contact-form-area w-form-old"
                                >
                                    <div class="margin-bottom margin-16px">
                                        <h2 class="heading-custom-h3">
                                            Envoyer un message
                                        </h2>
                                    </div>
                                    <ContactForm />
                                </div>
                            </div>
                            <v-lazy-image
                                src="/cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677652337172d5876dc18fbc_Website-Shape.svg"
                                alt="Shape"
                                class="contact-hero-shape"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
