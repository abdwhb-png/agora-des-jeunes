<style>
.rich-text-privacy-policy {
    line-height: 1.6;
}

.rich-text-privacy-policy :where(h1, h2, h3, h4, h5, h6) {
    margin: 10px 0;
}

.rich-text-privacy-policy hr {
    margin: 40px 20px;
}

.rich-text-privacy-policy p {
    margin-bottom: 15px;
}

.rich-text-privacy-policy a {
    text-decoration: underline;
}
</style>

<script setup>
import HomeLayout from "@/Layouts/HomeLayout.vue";

defineProps({
    content: String,
    title: String,
    description: String,
    lastUpdate: {
        type: String,
        default: "01 mars 2025",
    },
});
</script>

<template>
    <HomeLayout :title="title">
        <template #header>
            <section class="section-privacy-policy-hero">
                <div class="section-spacer">
                    <div
                        class="hero-section-padding is-cover-hero"
                        style="padding-bottom: 30px"
                    >
                        <div class="container">
                            <div class="content-align-center">
                                <div class="margin-bottom margin-24px">
                                    <h1
                                        data-w-id="cfcb6f2b-8c6c-4aa7-557a-1446174aa9f9"
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
                                    >
                                        {{ title }}
                                    </h1>
                                </div>
                                <p
                                    data-w-id="1b25ea0c-96d9-1a7d-7364-d48219dd23fa"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        opacity: 1;
                                        transform-style: preserve-3d;
                                    "
                                    class="font-bold"
                                >
                                    Dernière mise à jour: {{ lastUpdate }}
                                </p>
                                <div
                                    v-html="
                                        description.replaceAll(
                                            'site_name',
                                            $page.props.app.name,
                                        )
                                    "
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </template>

        <section class="section-privacy-policy-main">
            <div class="padding-global section-padding-regular">
                <div class="container-fixed">
                    <div
                        data-w-id="b565a616-e7ce-c202-6346-5706fc30a0c9"
                        style="
                            transform: translate3d(0px, 0px, 0px)
                                scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                rotateZ(0deg) skew(0deg, 0deg);
                            opacity: 1;
                            transform-style: preserve-3d;
                        "
                        class="rich-text-privacy-policy w-richtext"
                        v-html="
                            content
                                .replaceAll(
                                    'contact_email',
                                    $page.props.config.site_email,
                                )
                                .replaceAll('site_name', $page.props.app.name)
                                .replaceAll('policy_url', route('policy.show'))
                        "
                    ></div>
                </div>
            </div>
        </section>
    </HomeLayout>
</template>
