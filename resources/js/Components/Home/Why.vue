<script setup>
import ItemsList from "./ItemsList.vue";

const list = [
    "<b>Une plateforme pensée pour TOI</b> : adaptée aux besoins des jeunes béninois.",
    "<b>Un espace d’apprentissage et d’action</b> : pour évoluer personnellement et professionnellement.",
    "<b>Un réseau engagé</b> : échange avec des experts, mentors et autres jeunes ambitieux.",
];
</script>

<template>
    <section class="section-cta">
        <div class="padding-global section-padding-regular">
            <div class="container">
                <div class="w-layout-grid cta-grid">
                    <div class="column column-sticky">
                        <div
                            id="w-node-_5a1155cd-90c3-d0fe-b46f-ae90403cea4c-159aea0c"
                            class="cta-image-wrapper"
                        >
                            <div class="cta-image-inner">
                                <v-lazy-image
                                    src="/images/francis-odeyemi-jLKDfxikHzM-unsplash.jpg"
                                    loading="lazy"
                                    alt="CTA Showcase Image"
                                    class="cta-showcase-image"
                                />
                            </div>
                            <v-lazy-image
                                src="/cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677652337172d5876dc18fbc_Website%20Shape.svg"
                                loading="lazy"
                                style="
                                    transform: translate3d(
                                            -5.412px,
                                            5.412px,
                                            0px
                                        )
                                        scale3d(1, 1, 1) rotateX(0deg)
                                        rotateY(0deg) rotateZ(0deg)
                                        skew(0deg, 0deg);
                                    transform-style: preserve-3d;
                                    will-change: transform;
                                "
                                data-w-id="d11e7362-4afa-f0e7-b813-ae678a6145a3"
                                alt="cta section graphical shape"
                                class="cta-shape-asset"
                            />
                        </div>
                    </div>
                    <div class="column">
                        <div class="cta-right-content">
                            <div class="margin-bottom margin-24px">
                                <h2
                                    data-w-id="b9e3a269-3ae5-9f4d-c84e-41ba03f054ae"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        transform-style: preserve-3d;
                                        opacity: 1;
                                    "
                                >
                                    Pourquoi
                                    <span class="color-primary">{{
                                        $page.props.app.name
                                    }}</span>
                                    ?
                                </h2>
                            </div>
                            <div class="margin-bottom margin-40px">
                                <p
                                    data-w-id="b9e3a269-3ae5-9f4d-c84e-41ba03f054b3"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        transform-style: preserve-3d;
                                        opacity: 1;
                                    "
                                >
                                    Nous sommes convaincus que laisser son
                                    avenir au hasard ou à d'autres personnes ne
                                    fera rien avancer.
                                    <br />
                                    C'est pour celà que nous avons créé
                                    <span class="font-medium"
                                        >{{ $page.props.app.name }} pour t'aider
                                        et te permettre de prendre en main ton
                                        avenir </span
                                    >.
                                </p>
                                <ItemsList :list="list" />
                            </div>
                            <div class="cta-button-area">
                                <div class="cta-button-wrapper">
                                    <div
                                        data-w-id="e58fe637-0b84-c4f5-9dde-81fa2ebbf1c4"
                                        style="
                                            transform: translate3d(
                                                    0px,
                                                    0px,
                                                    0px
                                                )
                                                scale3d(1, 1, 1) rotateX(0deg)
                                                rotateY(0deg) rotateZ(0deg)
                                                skew(0deg, 0deg);
                                            transform-style: preserve-3d;
                                            opacity: 1;
                                        "
                                        class="animate"
                                    >
                                        <Link
                                            data-wf--button-primary-with-icon--variant="base"
                                            :href="route('register')"
                                            class="button-primary-wrapper w-inline-block"
                                            ><div
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
                                                        <span
                                                            class="button-icon"
                                                            ><i
                                                                class="pi pi-arrow-circle-right"
                                                            ></i>
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="button-text-wrapper"
                                                    >
                                                        <div
                                                            class="button-text"
                                                        >
                                                            Je Rejoins
                                                            Maintenant
                                                        </div>
                                                        <div
                                                            class="button-text is-behind"
                                                        >
                                                            Je Rejoins
                                                            Maintenant
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </Link>
                                    </div>
                                </div>
                                <p
                                    data-w-id="b9e3a269-3ae5-9f4d-c84e-41ba03f054ba"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        transform-style: preserve-3d;
                                        opacity: 1;
                                    "
                                    class="cta-text"
                                >
                                    Ne laisse plus ton avenir au hasard. Prends
                                    le contrôle !
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
