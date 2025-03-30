<script setup>
import Features from "@/Components/Home/Features.vue";
import GetToKnow from "@/Components/Home/GetToKnow.vue";
import HowItWorks from "@/Components/Home/HowItWorks.vue";
import IndexHeader from "@/Components/Home/IndexHeader.vue";
import Why from "@/Components/Home/Why.vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";
</script>

<template>
    <HomeLayout title="Accueil" :meta="$page.props.meta">
        <template #header>
            <IndexHeader />
        </template>

        <section class="section-why-us" id="discover">
            <div class="padding-global section-padding-regular">
                <div class="container">
                    <div class="margin-bottom margin-5px">
                        <div
                            data-w-id="e9455644-14f2-71a0-efb9-fdc168804b44"
                            class="margin-bottom margin-24px set-animation"
                            data-animation="animate__slideInUp"
                        >
                            <div class="content-align-center">
                                <div
                                    data-wf--ui-section-subtitle--variant="base"
                                    class="section-subtitle-wrapper"
                                >
                                    <SubtitleIcon
                                        class="section-subtitle-icon main-animation"
                                    />
                                    <p class="section-subtitle uppercase">
                                        Ton futur commence ici : Apprends,
                                        Connecte-toi, Agis
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            data-w-id="6898c518-4252-720f-a2fa-5631d1294c7a"
                            class="margin-bottom margin-24px"
                        >
                            <h2
                                class="text-align-center set-animation"
                                data-animation="animate__lightSpeedInLeft"
                                data-no-repeat="true"
                            >
                                Introduction à
                                <span class="color-primary">{{
                                    $page.props.app.name
                                }}</span>
                            </h2>
                        </div>
                        <p
                            id="start"
                            data-w-id="939075c9-95f8-d793-c179-46f996358825"
                            class="why-us-section-info main-animation"
                        >
                            <span class="underline">
                                Tu veux savoir comment lancer et réussir ton
                                projet ?
                            </span>
                            <br />
                            Besoin d'un CV impactant ? Un emploi ? Une bourse
                            d’études ?
                            <br />
                            Tout est ici !
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
