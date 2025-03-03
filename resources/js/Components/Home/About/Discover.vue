<script setup>
import { usePage } from "@inertiajs/vue3";
import ItemsList from "../ItemsList.vue";
const page = usePage();

const items = [
    {
        label: "Mission",
        image: "https://cdn.prod.website-files.com/67590e9b756ef477159ae9e4/6790cf7a6b13913d42ab7437_our%20journey%20image%20one.avif",
        title: "Notre Mission : Donner aux jeunes les moyens d’agir",
        text: `Accompagner, former et connecter les jeunes pour qu’ils puissent réaliser
            leur plein potentiel et impacter positivement leur communauté.
            Nous offrons une plateforme unique qui combine éducation, développement personnel
             et opportunités professionnelles pour les jeunes.`,
        list: [
            "Fournir une plateforme d’apprentissage et d’action pour les jeunes.",
            "Sensibiliser sur des sujets cruciaux comme les droits, le harcèlement et la citoyenneté.",
            "Promouvoir l’égalité des genres et encourager l’inclusion sociale.",
            "Renforcer les compétences personnelles et professionnelles pour faire de chaque participant un acteur du changement.",
        ],
    },
    {
        label: "Vision",
        image: "/images/etty-fidele-YYfzJhfNU14-unsplash.jpg",
        title: "Notre Vision : Bâtir une génération de leaders engagés",
        text: `Nous aspirons à voir émerger une génération de jeunes éclairés et actifs,
            capables de relever les défis du XXIe siècle et de participer activement au développement de leur pays.
            Nous voulons créer un écosystème dynamique où chaque jeune peut apprendre, s’informer, se former et
            saisir les opportunités qui s’offrent à lui.`,
        list: {
            "Contibution Sociale":
                "Imaginer un monde où chaque jeune trouve sa place et contribue activement au progrès social, économique et culturel.",
            Leadership:
                "Former des leaders qui inspirent, éduquent et rassemblent autour d’initiatives porteuses de changement.",
            "Equité et Respect":
                "Créer une société où les valeurs d’équité, de respect et d’innovation sont au cœur de chaque action.",
        },
    },
    {
        label: "Engagements",
        title: "Nous nous engageons à croire en chaque jeune et son potentiel",
        text: `Il est nécessaire d'accompagner les jeunes dans leur parcours de développement
            à travers des formations, des échanges constructifs et des initiatives innovantes.`,
        list: [
            "Favoriser l’éducation et l’accès aux opportunités.",
            "Encourager l’innovation et l’entrepreneuriat.",
            "Sensibiliser sur les enjeux sociaux et citoyens.",
            "Créer un réseau de soutien et de collaboration.",
        ],
    },
];
</script>

<template>
    <section class="section-our-journey" id="discover">
        <div class="padding-global section-padding-regular is-bottom-zero">
            <div class="container">
                <div class="our-journey-main">
                    <div class="margin-bottom margin-60px">
                        <h2
                            data-w-id="a94f4d44-daef-2143-4adc-ed72663f6807"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                opacity: 1;
                                transform-style: preserve-3d;
                            "
                            class="our-journey-heading"
                        >
                            Bâtir une génération de
                            <span class="color-primary">leaders engagés</span>.
                        </h2>
                    </div>
                    <div
                        data-current="Tab 1"
                        data-easing="ease"
                        data-duration-in="300"
                        data-duration-out="100"
                        class="our-journey-tabs w-tabs"
                    >
                        <div
                            id="w-node-e598291f-7531-1c79-1544-55e6aa9da07e-159aea3c"
                            data-w-id="e598291f-7531-1c79-1544-55e6aa9da07e"
                            style="
                                transform: translate3d(0px, 0px, 0px)
                                    scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                    rotateZ(0deg) skew(0deg, 0deg);
                                opacity: 1;
                                transform-style: preserve-3d;
                            "
                            class="our-journey-tab-menu w-tab-menu"
                            role="tablist"
                        >
                            <a
                                v-for="(item, index) in items"
                                :key="item.label || item.title"
                                :data-w-tab="'Tab ' + (index + 1)"
                                class="our-journey-tab-link w-inline-block w-tab-link"
                                :class="{ 'w--current': index == 0 }"
                                :id="'w-tabs-0-data-w-tab-' + index"
                                :href="'#w-tabs-0-data-w-pane-' + index"
                                role="tab"
                                :aria-controls="'w-tabs-0-data-w-pane-' + index"
                                :aria-selected="index == 0"
                            >
                                <span class="heading-custom-h5">
                                    {{ item.label }}
                                </span>
                            </a>
                        </div>
                        <div class="our-journey-tabs-content w-tab-content">
                            <div
                                v-for="(item, index) in items"
                                :key="item.label || item.title"
                                :id="'w-tabs-0-data-w-pane-' + index"
                                :data-w-tab="'Tab ' + (index + 1)"
                                class="our-journey-tab-pane w-tab-pane"
                                :class="{ 'w--tab-active': index == 0 }"
                                role="tabpanel"
                                :aria-labelledby="
                                    'w-tabs-0-data-w-tab-' + index
                                "
                                style="
                                    opacity: 1;
                                    transition:
                                        all,
                                        opacity 300ms;
                                "
                            >
                                <div class="our-journey-tab-item">
                                    <div class="our-journey-item-left">
                                        <div
                                            data-w-id="32f8200b-69bc-0007-a624-f8de7809e1db"
                                            style="
                                                transform: translate3d(
                                                        0px,
                                                        0px,
                                                        0px
                                                    )
                                                    scale3d(1, 1, 1)
                                                    rotateX(0deg) rotateY(0deg)
                                                    rotateZ(0deg)
                                                    skew(0deg, 0deg);
                                                opacity: 1;
                                                transform-style: preserve-3d;
                                            "
                                            class="margin-bottom margin-24px"
                                        >
                                            <h2>
                                                {{ item.title }}
                                            </h2>
                                        </div>
                                        <div class="margin-bottom margin-24px">
                                            <p
                                                data-w-id="32f8200b-69bc-0007-a624-f8de7809e1df"
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
                                                    opacity: 1;
                                                    transform-style: preserve-3d;
                                                "
                                            >
                                                {{ item.text }}
                                            </p>
                                        </div>
                                        <ItemsList :list="item.list || []" />
                                    </div>
                                    <div
                                        v-if="item.image"
                                        id="w-node-_32f8200b-69bc-0007-a624-f8de7809e1f1-159aea3c"
                                        data-w-id="32f8200b-69bc-0007-a624-f8de7809e1f1"
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
                                        class="our-journey-item-right"
                                    >
                                        <v-lazy-image
                                            :src="item.image"
                                            :alt="'image de ' + item.label"
                                            class="our-journey-right-thumb"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
