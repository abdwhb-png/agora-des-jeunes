<script setup>
defineProps({
    features: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <section class="section-quick-insight" id="features">
        <div class="padding-global">
            <div class="container">
                <div class="space-padding-regular"></div>
                <div class="margin-bottom margin-60px">
                    <h2
                        data-w-id="31f7863a-6d63-8c26-fc5b-947444c7a8b8"
                        class="quick-insight-section-title set-animation"
                        data-animation="animate__fadeInUp"
                    >
                        Fonctionnalités Principales
                    </h2>
                </div>
                <div class="w-layout-grid quick-insight-grid">
                    <div class="column column-sticky">
                        <div
                            id="w-node-_4292c58b-082e-79a8-fd5d-117a45420a1c-159aea28"
                            data-w-id="4292c58b-082e-79a8-fd5d-117a45420a1c"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                opacity: 1;
                                transform-style: preserve-3d;
                            "
                            class="quick-insight-image-wrapper"
                        >
                            <div class="quick-insight-image-inner">
                                <v-lazy-image
                                    src="https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677782c896e04ee61edc1fc6_Layer%20Blur.png"
                                    loading="lazy"
                                    sizes="(max-width: 604px) 92vw, (max-width: 767px) 556px, (max-width: 991px) 94vw, (max-width: 1279px) 100vw, 1136px"
                                    srcset="
                                        https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677782c896e04ee61edc1fc6_Layer%20Blur-p-500.png 500w,
                                        https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677782c896e04ee61edc1fc6_Layer%20Blur.png       556w
                                    "
                                    alt="layer blur"
                                    class="insight-layer-blur"
                                />
                                <opt-img
                                    path="/images/clout-africa-yhzWaCDebAk-unsplash.jpg"
                                    loading="lazy"
                                    alt="quick insight section image"
                                    class="quick-insight-image"
                                />
                                <v-lazy-image
                                    src="/images/bot.webp"
                                    loading="lazy"
                                    data-w-id="8d473d9f-259a-0e3a-3946-7d3f0143614b"
                                    alt="Bot Agora des jeunes"
                                    class="insight-matrix"
                                    style="
                                        will-change: transform;
                                        transform: translate3d(
                                                0px,
                                                -13.2891%,
                                                0px
                                            )
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        transform-style: preserve-3d;
                                    "
                                />
                            </div>
                            <img
                                src="https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677652337172d5876dc18fbc_Website%20Shape.svg"
                                loading="lazy"
                                style="
                                    transform: translate3d(
                                            -6.9892px,
                                            6.9892px,
                                            0px
                                        )
                                        scale3d(1, 1, 1) rotateX(0deg)
                                        rotateY(0deg) rotateZ(0deg)
                                        skew(0deg, 0deg);
                                    transform-style: preserve-3d;
                                    will-change: transform;
                                "
                                data-w-id="4292c58b-082e-79a8-fd5d-117a45420a20"
                                alt="insight section graphical shape"
                                class="quick-insight-section-shape"
                            />
                        </div>
                    </div>
                    <div
                        id="w-node-_8373e231-be89-da29-dd55-516b3e3b607c-159aea28"
                        class="column"
                    >
                        <div
                            data-current="Tab 1"
                            data-easing="ease"
                            data-duration-in="300"
                            data-duration-out="100"
                            class="quick-insight-tab w-tabs"
                        >
                            <div
                                v-for="(feature, index) in features"
                                :key="feature.id || index"
                                class="dsy-collapse dsy-collapse-arrow bg-base-100 border border-base-300 mb-3"
                            >
                                <input
                                    type="radio"
                                    name="features-accordion"
                                    checked="checked"
                                />
                                <div
                                    class="dsy-collapse-title heading-custom-h5"
                                >
                                    {{ feature.name }}
                                </div>
                                <div
                                    class="dsy-collapse-content insight-tab-item-detail-text"
                                >
                                    {{ feature.description }}
                                    <Link
                                        :href="route('dashboard')"
                                        class="link"
                                    >
                                        Commencer
                                    </Link>
                                </div>
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
