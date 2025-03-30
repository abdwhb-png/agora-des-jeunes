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
                                src="/images/about/history.png"
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
                        <div class="margin-bottom margin-16px set-animation">
                            <div
                                data-wf--ui-section-subtitle--variant="base"
                                class="section-subtitle-wrapper"
                            >
                                <SubtitleIcon class="section-subtitle-icon" />
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
                                succès tout en leur permettant de grandir,
                                d’apprendre et d’agir dans un cadre positif et
                                inspirant.
                            </blockquote>
                        </div>
                        <div
                            data-w-id="429d87fa-9297-1f6d-50b3-90e037bd901b"
                            class="set-animation"
                            data-animation="animate__fadeInUp"
                            data-no-repeat="true"
                        >
                            <UiButton as-child variant="secondary">
                                <Link :href="route('register')"
                                    >Rejoindre la communauté</Link
                                >
                            </UiButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
