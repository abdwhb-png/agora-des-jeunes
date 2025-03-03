<script setup>
const items = [
    {
        title: "Leadership inspirant",
        text: "Encourager les jeunes à développer leurs compétences en leadership pour inspirer et guider positivement leur communauté.",
        list: [
            "Former des leaders capables de prendre des décisions éclairées et de motiver les autres.",
            "Favoriser l’apprentissage du leadership collaboratif, basé sur l’écoute et l’action constructive.",
            "Promouvoir l’importance de l’exemplarité dans les comportements individuels et collectifs.",
        ],
        img: "values-icon-5.svg",
    },
    {
        title: "Apprentissage continu",
        text: "Favoriser le développement personnel et professionnel à travers des opportunités éducatives enrichissantes.",
        list: [
            "Offrir des formations pratiques et interactives dans des domaines clés comme la gestion du temps, le leadership et la vie sexuelle et reproductive.",
            "Encourager les jeunes à développer leur esprit critique et à explorer de nouvelles perspectives.",
            "Proposer un cadre d’apprentissage collaboratif basé sur le partage d’expériences.",
        ],
        img: "values-icon-1.svg",
    },
    {
        title: "Innovation sociale",
        text: "Susciter la créativité et encourager des idées audacieuses pour résoudre les défis sociaux et économiques actuels.",
        list: [
            "Valoriser les projets novateurs et soutenir les jeunes porteurs de solutions.",
            "Mettre en avant des approches nouvelles pour traiter des thématiques comme le harcèlement, la citoyenneté et la gouvernance.",
            "Favoriser l’usage des technologies pour accélérer le changement social.",
        ],
        img: "values-icon-2.svg",
    },
    {
        title: "Collaboration et réseautage",
        text: "Créer des opportunités de connexion entre les jeunes, les mentors et les experts pour renforcer leur impact collectif.",
        list: [
            "Faciliter les échanges entre pairs et professionnels partageant des intérêts communs.",
            "Organiser des événements de réseautage pour stimuler les collaborations.",
            "Construire une communauté solidaire où l’entraide et la mise en relation sont valorisées.",
        ],
        img: "values-icon-4.svg",
    },
    {
        title: "Engagement communautaire",
        text: "Motiver les jeunes à s’impliquer activement dans des initiatives locales et nationales pour bâtir une société meilleure.",
        list: [
            "Renforcer le sens de responsabilité des jeunes envers leur communauté.",
            "Promouvoir des actions participatives qui répondent aux besoins sociaux et environnementaux.",
            "Former des ambassadeurs du changement social, prêts à relever les défis de leur époque.",
        ],
        img: "values-icon-6.svg",
    },
    {
        title: "Égalité et inclusion",
        text: "Garantir un environnement accessible et respectueux où chaque jeune, quel que soit son genre, son origine ou sa condition, se sent valorisé.",
        list: [
            "Lutter contre toutes les formes de discrimination et d’inégalités.",
            "Sensibiliser à l’égalité des genres et promouvoir la participation équitable des filles et des garçons.",
            "Créer un espace où les voix de tous sont entendues et respectées.",
        ],
        img: "values-icon-3.svg",
    },
];
</script>

<template>
    <section class="section-our-features">
        <div class="padding-global section-padding-regular is-bottom-zero">
            <div class="container">
                <div class="margin-bottom margin-60px">
                    <h2
                        data-w-id="13038584-1b14-5a76-2644-c0bd12e9e7d7"
                        style="
                            transform: translate3d(0px, 0px, 0px)
                                scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                rotateZ(0deg) skew(0deg, 0deg);
                            opacity: 1;
                            transform-style: preserve-3d;
                        "
                        class="features-section-title tracking-wide"
                    >
                        Toutes nos actions sont guidées par
                        <span class="color-primary">Nos Valeurs </span>
                        qui définissent l’essence même de notre initiative.
                    </h2>
                </div>
                <div class="feature-item-wrapper">
                    <div
                        v-for="(item, index) in items"
                        :key="item.title"
                        :data-w-id="'f53211b0 - 9418 - f943 - a12e - ecd633409e17'"
                        class="feature-item"
                        style="
                            transform: translate3d(0px, 0px, 0px)
                                scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                rotateZ(0deg) skew(0deg, 0deg);
                            transform-style: preserve-3d;
                            opacity: 1;
                        "
                    >
                        <div class="margin-bottom margin-24px">
                            <div class="why-item-icon-wrapper">
                                <v-lazy-image
                                    :src="`/images/about/${item.img}`"
                                    loading="lazy"
                                    :alt="'icon ' + item.title"
                                    class="why-item-icon"
                                />
                            </div>
                        </div>
                        <div class="feature-item-content">
                            <div class="margin-bottom margin-16px">
                                <h3 class="feature-item-title">
                                    {{ item.title }}
                                </h3>
                            </div>
                            <p>
                                {{ item.text }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
