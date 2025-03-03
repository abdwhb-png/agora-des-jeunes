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
                        style="
                            transform: translate3d(0px, 0px, 0px)
                                scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                rotateZ(0deg) skew(0deg, 0deg);
                            opacity: 1;
                            transform-style: preserve-3d;
                        "
                        class="quick-insight-section-title"
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
                                <img
                                    src="https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677782c896e04ee61edc1fc6_Layer%20Blur.png"
                                    loading="lazy"
                                    sizes="(max-width: 604px) 92vw, (max-width: 767px) 556px, (max-width: 991px) 94vw, (max-width: 1279px) 100vw, 1136px"
                                    srcset="
                                        https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677782c896e04ee61edc1fc6_Layer%20Blur-p-500.png 500w,
                                        https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677782c896e04ee61edc1fc6_Layer%20Blur.png       556w
                                    "
                                    alt="layer blur"
                                    class="insight-layer-blur"
                                /><img
                                    src="https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/67887ed56252f1cd7429f7ff_Quick%20Insight%20Section%20Image.avif"
                                    loading="lazy"
                                    sizes="(max-width: 767px) 92vw, (max-width: 991px) 94vw, (max-width: 1279px) 100vw, 1136px"
                                    srcset="
                                        https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/67887ed56252f1cd7429f7ff_Quick%20Insight%20Section%20Image-p-500.avif  500w,
                                        https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/67887ed56252f1cd7429f7ff_Quick%20Insight%20Section%20Image.avif       1668w
                                    "
                                    alt="quick insight section image"
                                    class="quick-insight-image"
                                /><img
                                    src="https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677784e464a7158f3d99b26d_Insight%20Value.png"
                                    loading="lazy"
                                    data-w-id="8d473d9f-259a-0e3a-3946-7d3f0143614b"
                                    alt="Insight Matrix"
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
                                class="quick-insight-tab-menu w-tab-menu"
                                role="tablist"
                            >
                                <a
                                    v-for="(feature, index) in features"
                                    :key="feature.id || index"
                                    :data-w-tab="'Tab ' + (index + 1)"
                                    data-w-id="2479cfd2-dcc6-96ac-bbc8-4e76a4bab60f"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        opacity: 1;
                                        transform-style: preserve-3d;
                                    "
                                    class="insight-tab-link w-inline-block w-tab-link"
                                    :id="'w-tabs-0-data-w-tab-' + index"
                                    :href="'#w-tabs-0-data-w-pane-' + index"
                                    role="tab"
                                    :aria-controls="
                                        'w-tabs-0-data-w-pane-' + index
                                    "
                                    aria-selected="false"
                                    tabindex="-1"
                                    ><div
                                        class="quick-insight-item"
                                        style="
                                            background-color: rgb(
                                                247,
                                                247,
                                                247
                                            );
                                        "
                                    >
                                        <div class="quick-insight-item-inner">
                                            <div
                                                class="insight-tab-question-area"
                                            >
                                                <div class="heading-custom-h5">
                                                    {{ feature.name }}
                                                </div>
                                                <div
                                                    class="insight-tab-icon-wrapper"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="100%"
                                                        viewBox="0 0 24 25"
                                                        fill="none"
                                                        class="insight-tab-arrow-icon"
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
                                                            transform-style: preserve-3d;
                                                        "
                                                    >
                                                        <path
                                                            d="M11.9997 13.6714L16.9495 8.72168L18.3637 10.1359L11.9997 16.4999L5.63574 10.1359L7.04996 8.72168L11.9997 13.6714Z"
                                                            fill="currentColor"
                                                        ></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div
                                                class="quick-insight-spacer"
                                                style="height: 0px"
                                            ></div>
                                            <p
                                                class="insight-tab-item-detail-text"
                                                style="opacity: 0; height: 0px"
                                            >
                                                {{ feature.description }}
                                                <Link
                                                    :href="route('dashboard')"
                                                    class="link"
                                                >
                                                    Commencer
                                                </Link>
                                            </p>
                                        </div>
                                    </div>
                                </a>
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
