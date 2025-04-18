<script setup>
import { ref } from "vue";
import ItemsList from "../ItemsList.vue";

const items = [
    {
        label: "Vision",
        image: "/images/about/vision.jpg",
        title: "Bâtir une génération de leaders engagés",
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
        label: "Mission",
        image: "/images/about/mission.jpg",
        title: "Donner aux jeunes les moyens d’agir",
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
        label: "Engagements",
        image: "/images/about/engagements.jpg",
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

const activeItem = ref(items[0]);
const tabContent = ref();

const changeItem = (item) => {
    if (tabContent.value) {
        tabContent.value.classList.add("animate-pulse");
        setTimeout(() => {
            tabContent.value.classList.remove("animate-pulse");
        }, 700);
    }
    activeItem.value = item;
};
</script>

<template>
    <section class="section-our-journey">
        <div class="padding-global section-padding-regular is-bottom-zero">
            <div class="container">
                <div class="our-journey-main">
                    <div data-current="Tab 1" data-easing="ease" data-duration-in="300" data-duration-out="100"
                        class="our-journey-tabs w-tabs">
                        <div id="w-node-e598291f-7531-1c79-1544-55e6aa9da07e-159aea3c"
                            class="our-journey-tab-menu w-tab-menu" style="justify-content: center !important;"
                            role="tablist">
                            <button v-for="(item, index) in items" :key="item.label || item.title" type="button"
                                class="our-journey-tab-link w-inline-block w-tab-link" :class="{
                                    'w--current':
                                        item.label == activeItem.label,
                                }" @click="changeItem(item)">
                                <span class="heading-custom-h5">
                                    {{ item.label }}
                                </span>
                            </button>
                        </div>
                        <div class="our-journey-tabs-content w-tab-content" ref="tabContent">
                            <div :data-w-tab="'Tab ' + activeItem.label"
                                class="our-journey-tab-pane w-tab-pane w--tab-active" role="tabpanel" style="
                                    opacity: 1;
                                    transition:
                                        all,
                                        opacity 300ms;
                                ">
                                <div class="our-journey-tab-item">
                                    <div class="our-journey-item-left">
                                        <div data-w-id="32f8200b-69bc-0007-a624-f8de7809e1db" style="
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
                                            " class="margin-bottom margin-24px">
                                            <h2>
                                                {{ activeItem.title }}
                                            </h2>
                                        </div>
                                        <div class="margin-bottom margin-24px">
                                            <p data-w-id="32f8200b-69bc-0007-a624-f8de7809e1df" style="
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
                                                ">
                                                {{ activeItem.text }}
                                            </p>
                                        </div>
                                        <ItemsList :list="activeItem.list || []" />
                                    </div>
                                    <div v-if="activeItem.image"
                                        id="w-node-_32f8200b-69bc-0007-a624-f8de7809e1f1-159aea3c"
                                        data-w-id="32f8200b-69bc-0007-a624-f8de7809e1f1" style="
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
                                        " class="our-journey-item-right">
                                        <opt-img :path="activeItem.image" :src="activeItem.image"
                                            :alt="'image de ' + activeItem.label" class="our-journey-right-thumb" />
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
