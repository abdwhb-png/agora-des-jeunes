<script setup lang="ts">
import { User2 } from "lucide-vue-next";
</script>

<template>
    <header class="section-hero">
        <div class="section-spacer">
            <div class="section-container">
                <div class="hero-wrapper">
                    <div class="container">
                        <div class="hero-row">
                            <div class="hero-main-content">
                                <h1
                                    data-w-id="ca1ca5dd-564e-e9e6-f68b-a5aa306b6cdd"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        opacity: 1;
                                        transform-style: preserve-3d;
                                    "
                                    class="hero-title"
                                >
                                    Un espace dédié pour les
                                    <span class="color-primary"
                                        >jeunes ambitieux</span
                                    >.
                                </h1>
                                <p
                                    data-w-id="e24309a2-1e52-20c2-f322-14de9cd464e3"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        opacity: 1;
                                        transform-style: preserve-3d;
                                    "
                                    class="hero-info"
                                >
                                    Bienvenue sur
                                    <a href="/" class="link underline">{{
                                        $page.props.app.name
                                    }}</a
                                    >, la plateforme qui t’accompagne dans ton
                                    éducation, ton développement personnel et
                                    ton avenir professionnel.
                                </p>
                                <div class="cta-button-wrapper is-hero">
                                    <div
                                        data-w-id="db6ef978-4025-5b83-6a7a-f904367bb636"
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
                                        class="hero-button"
                                    >
                                        <Link
                                            data-wf--button-primary-with-icon--variant="base"
                                            :href="route('register')"
                                            class="button-primary-wrapper w-inline-block"
                                        >
                                            <div
                                                class="button-shadow"
                                                style="
                                                    transform: translate3d(
                                                            8px,
                                                            8px,
                                                            0px
                                                        )
                                                        scale3d(1, 1, 1)
                                                        rotateX(0deg)
                                                        rotateY(0deg)
                                                        rotateZ(0deg)
                                                        skew(0deg, 0deg);
                                                    transform-style: preserve-3d;
                                                "
                                            ></div>
                                            <div class="button-primary">
                                                <div
                                                    class="button-content-wrapper"
                                                >
                                                    <div
                                                        class="button-icon-wrapper"
                                                    >
                                                        <User2
                                                            class="button-icon"
                                                        />
                                                    </div>
                                                    <div
                                                        class="button-text-wrapper"
                                                    >
                                                        <div
                                                            class="button-text"
                                                        >
                                                            Devenir membre
                                                        </div>
                                                        <div
                                                            class="button-text is-behind"
                                                        >
                                                            Inscription/Connexion
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </Link>
                                    </div>
                                    <div
                                        data-w-id="51ec3382-cca5-c9bd-687d-66b002ee5bb2"
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
                                        class="hero-button"
                                    >
                                        <BtnLink
                                            href="#discover"
                                            variant="secondary"
                                            text="En apprendre plus"
                                            behind-text="Je découvre"
                                        >
                                            <template #icon>
                                                <StarsIcon
                                                    class="button-icon"
                                                />
                                            </template>
                                        </BtnLink>
                                    </div>
                                </div>
                                <p
                                    data-w-id="a68616db-6788-1a4d-2463-119df4aafd93"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        opacity: 1;
                                        transform-style: preserve-3d;
                                    "
                                    class="cta-text"
                                >
                                    Engage-toi, Exprime toi...
                                    <br />
                                    C'est le lieu où l'avenir prend forme !
                                </p>
                            </div>
                            <div class="hero-image-wrapper">
                                <opt-img
                                    class="hero-image"
                                    path="/images/Layerr-2x.png"
                                    width="Auto"
                                    height="Auto"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <ShapeIcon
                    style="
                        opacity: 1;
                        transform: translate3d(-8.1628px, 8.1628px, 0px)
                            scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                            rotateZ(0deg) skew(0deg, 0deg);
                        transform-style: preserve-3d;
                        will-change: transform;
                    "
                    class="hero-shape-two hidden md:block"
                />
            </div>
        </div>
    </header>
</template>
