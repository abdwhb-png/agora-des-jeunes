<template>
    <section class="section-our-story">
        <div class="padding-global section-padding-regular is-bottom-zero">
            <div class="container">
                <div class="our-story-main">
                    <div class="our-story-left">
                        <div
                            data-w-id="0356a5b9-06ed-d60f-6d5b-ba4e86dedefd"
                            class="our-story-thumb-wrap"
                        >
                            <v-lazy-image
                                src="/images/about/main.png"
                                loading="lazy"
                                style="
                                    transform: translate3d(0px, 0px, 0px)
                                        scale3d(1, 1, 1) rotateX(0deg)
                                        rotateY(0deg) rotateZ(0deg)
                                        skew(0deg, 0deg);
                                    transform-style: preserve-3d;
                                "
                                sizes="(max-width: 479px) 93vw, (max-width: 767px) 95vw, (max-width: 991px) 45vw, (max-width: 1279px) 46vw, 524px"
                                alt="image de notre histoire"
                                class="image-cover"
                            />
                            <div
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
                    </div>
                    <div class="our-story-right">
                        <div
                            data-w-id="1264f29d-45c4-7115-92b7-bd0984d8dfc9"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                opacity: 1;
                                transform-style: preserve-3d;
                            "
                            class="margin-bottom margin-16px"
                        >
                            <div
                                data-wf--ui-section-subtitle--variant="base"
                                class="section-subtitle-wrapper"
                            >
                                <img
                                    src="https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/6774def2949f4571378328fa_Section%20Subtitle%20Icon.svg"
                                    loading="lazy"
                                    data-w-id="24d52241-d76b-7d8e-9564-1ed94bdc6613"
                                    alt="Section Subtitle Icon"
                                    class="section-subtitle-icon"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(360deg)
                                            skew(0deg, 0deg);
                                        transform-style: preserve-3d;
                                    "
                                />
                                <p class="section-subtitle">Notre histoire</p>
                            </div>
                        </div>
                        <div
                            data-w-id="5fae018c-774c-67a9-c4b6-aa141a12d074"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                opacity: 1;
                                transform-style: preserve-3d;
                            "
                            class="margin-bottom margin-30px"
                        >
                            <h2>
                                Voici comment
                                <span class="color-primary">{{
                                    $page.props.app.name
                                }}</span>
                                a vu le jour
                            </h2>
                        </div>
                        <div
                            data-w-id="676e36f4-6843-9545-e63f-85f820c2a945"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                opacity: 1;
                                transform-style: preserve-3d;
                            "
                            class="margin-bottom margin-30px"
                        >
                            <p class="our-story-section-info">
                                Née d’un constat simple mais puissant : les
                                jeunes d’aujourd’hui sont les leaders de demain.
                            </p>
                            <blockquote>
                                {{ $page.props.app.name }} a été créer pour
                                donner aux jeunes les outils nécessaires à leur
                                succès, leur permettre de grandir, d’apprendre
                                et d’agir dans un cadre positif et inspirant.
                            </blockquote>
                        </div>
                        <div
                            data-w-id="429d87fa-9297-1f6d-50b3-90e037bd901b"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                opacity: 1;
                                transform-style: preserve-3d;
                            "
                            class="animate"
                        >
                            <Link
                                data-wf--button-button-primary--variant="base"
                                :href="route('register')"
                                class="button-primary-wrapper w-inline-block"
                                ><div
                                    class="button-shadow"
                                    style="
                                        transform: translate3d(8px, 8px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        transform-style: preserve-3d;
                                    "
                                ></div>
                                <div class="button-primary">
                                    <div class="button-text-wrapper">
                                        <div class="button-text">
                                            Nous rejoindre
                                        </div>
                                        <div class="button-text is-behind">
                                            Nous rejoindre
                                        </div>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
