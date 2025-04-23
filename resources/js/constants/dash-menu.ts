import type { DefineComponent } from "vue";
import AgoraList from "@/Pages/Gestion/Partials/AgoraSessions/AgoraList.vue";
import AgoraForm from "@/Pages/Gestion/Partials/AgoraSessions/AgoraForm.vue";
import PollList from "@/Pages/Gestion/Partials/Polls/PollList.vue";
import PollForm from "@/Pages/Gestion/Partials/Polls/PollForm.vue";
import FaqList from "@/Pages/Gestion/Partials/Faqs/FaqList.vue";
import FaqForm from "@/Pages/Gestion/Partials/Faqs/FaqForm.vue";
import TrainingForm from "@/Pages/Gestion/Partials/Trainings/TrainingForm.vue";
import TrainingList from "@/Pages/Gestion/Partials/Trainings/TrainingList.vue";
import JobList from "@/Pages/Gestion/Partials/JobOffers/JobList.vue";
import JobForm from "@/Pages/Gestion/Partials/JobOffers/JobForm.vue";

type VueComponent = DefineComponent<any, any, any>;

interface MenuConfig {
    title: string;
    description: string;
    btnText: string;
    image: string;
    formComponent: VueComponent;
    listComponent: VueComponent;
}

export const MENU_CONFIGS = {
    AGORA: {
        title: "Session d'Agora",
        description:
            "Créer, consulter et gérer les différentes sessions d'Agora.",
        btnText: "Créer une Session",
        image: "/gestion/images/presentation.png",
        formComponent: AgoraForm,
        listComponent: AgoraList,
    },
    POLLS: {
        title: "Sondages",
        description: "Créer, consulter et gérer les différents sondages.",
        btnText: "Créer un Sondage",
        image: "/gestion/images/vote.png",
        formComponent: PollForm,
        listComponent: PollList,
    },
    FAQS: {
        title: "Foire aux Questions",
        description:
            "Créer, consulter et gérer les différentes questions réponses.",
        btnText: "Créer une FAQ",
        image: "/gestion/images/faq.png",
        formComponent: FaqForm,
        listComponent: FaqList,
    },
    TRAININGS: {
        title: "Formations",
        description: "Créer, consulter et gérer les formations.",
        btnText: "Ajouter une Formation",
        image: "/gestion/images/formation.png",
        formComponent: TrainingForm,
        listComponent: TrainingList,
    },
    JOB_OFFERS: {
        title: "Offres d'emploi",
        description: "Créer, consulter et gérer les offres d'emploi.",
        btnText: "Ajouter une Offre",
        image: "/gestion/images/emploi.png",
        formComponent: JobForm,
        listComponent: JobList,
    },
} as const satisfies Record<string, MenuConfig>;

export type MenuConfigKey = keyof typeof MENU_CONFIGS;
