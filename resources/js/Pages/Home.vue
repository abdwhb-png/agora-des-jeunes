<script setup>
import Features from "@/Components/Home/Features.vue";
import GetToKnow from "@/Components/Home/GetToKnow.vue";
import HowItWorks from "@/Components/Home/HowItWorks.vue";
import IndexHeader from "@/Components/Home/IndexHeader.vue";
import Why from "@/Components/Home/Why.vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";
</script>

<template>
    <HomeLayout title="Accueil">
        <template #header>
            <IndexHeader />
        </template>

        <section class="section-why-us">
            <div class="padding-global section-padding-regular">
                <div class="container">
                    <div class="margin-bottom margin-5px">
                        <div
                            data-w-id="e9455644-14f2-71a0-efb9-fdc168804b44"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                opacity: 1;
                                transform-style: preserve-3d;
                            "
                            class="margin-bottom margin-24px"
                        >
                            <div class="content-align-center">
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
                                            transform: translate3d(
                                                    0px,
                                                    0px,
                                                    0px
                                                )
                                                scale3d(1, 1, 1) rotateX(0deg)
                                                rotateY(0deg) rotateZ(360deg)
                                                skew(0deg, 0deg);
                                            transform-style: preserve-3d;
                                        "
                                    />
                                    <p class="section-subtitle uppercase">
                                        Ton futur commence ici : Apprends,
                                        Connecte-toi, Agis !
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            data-w-id="6898c518-4252-720f-a2fa-5631d1294c7a"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                opacity: 1;
                                transform-style: preserve-3d;
                            "
                            class="margin-bottom margin-24px"
                        >
                            <h2 class="text-align-center">
                                Introduction à
                                <span class="color-primary">{{
                                    $page.props.app.name
                                }}</span>
                            </h2>
                        </div>
                        <p
                            id="start"
                            data-w-id="939075c9-95f8-d793-c179-46f996358825"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                opacity: 1;
                                transform-style: preserve-3d;
                            "
                            class="why-us-section-info"
                        >
                            Tu veux un CV impactant ? Un emploi ? Une bourse
                            d’études ?
                            <br />
                            Des conseils pour lancer ton projet ? Tout est ici !
                            <br />
                            📢 Rejoins une communauté engagée et prends en main
                            ton futur dès aujourd’hui !
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <GetToKnow />
        <Features :features="$page.props.features" />
        <HowItWorks />
        <Why />
    </HomeLayout>
</template>
