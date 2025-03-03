<template>
    <MainLayout title="Mon Compte">
        <div
            class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5 lg:gap-7.5"
        >
            <div
                v-for="(item, index) in items"
                :key="item.url || index"
                class="card p-5 lg:p-7.5 lg:pt-7 cursor-pointer"
                @click="goTo(item)"
            >
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between gap-2">
                        <i :class="`${item.icon} text-2xl link`"> </i>
                    </div>
                    <div class="flex flex-col gap-3">
                        <span
                            class="text-base font-medium leading-none text-gray-900 hover:text-primary-active"
                        >
                            {{ item.title }}
                        </span>
                        <span class="text-2sm text-gray-700 leading-5">
                            {{ item.description }}
                        </span>
                    </div>
                </div>
            </div>

            <Dialog
                v-model:visible="showDialog"
                @hide="currentItem = null"
                modal
                :header="currentItem?.title"
                :style="{ width: '50rem' }"
                :breakpoints="dialogBreakpoints"
            >
                <component
                    v-if="currentItem"
                    :is="currentItem.component"
                    v-bind="currentItem?.props || {}"
                />
            </Dialog>
        </div>
    </MainLayout>
</template>

<script setup lang="ts">
import { router, usePage } from "@inertiajs/vue3";
import { markRaw, ref, onMounted } from "vue";
import { useUserStore } from "@/stores/user";
import { dialogBreakpoints, getIcon } from "@/utils/helpers";

import EmailAndPassword from "./Partials/EmailAndPassword.vue";
import Activities from "./Partials/Activities.vue";
import LogoutOtherBrowserSessionsForm from "./Partials/LogoutOtherBrowserSessionsForm.vue";
import EditProfilePhoto from "@/Pages/Profile/Partials/EditProfilePhoto.vue";
import ProfileStepper from "@/Pages/Profile/Partials/ProfileStepper.vue";

interface Item {
    icon: string;
    title: string;
    url?: string;
    component?: any;
    props?: any;
    description?: string;
}

const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    account_activities: Object,
});

const page = usePage();
const userStore = useUserStore();

const showDialog = ref(false);
const currentItem = ref<Item | null>(null);

const goTo = (item: Item) => {
    if (item.component) {
        currentItem.value = item;
        showDialog.value = true;
    } else if (item.url) {
        router.visit(item.url);
    }
};

const items = ref<Item[]>([
    {
        icon: getIcon("profile"),
        title: "A propos de moi",
        component: markRaw(ProfileStepper),
        props: { user: page.props.auth.user },
        description:
            "Gère tes informations personnelles et met à jour ton profil.",
    },
    {
        icon: "ki-filled ki-security-user",
        title: "Email & Mot de passe",
        component: markRaw(EmailAndPassword),
        props: { user: page.props.auth.user },
        description: "Modifie ton email ou ton mot de passe.",
    },
    {
        icon: getIcon("profile_pic"),
        title: "Photo de Profil",
        component: markRaw(EditProfilePhoto),
        props: { user: page.props.auth.user },
        description: "Change ta photo de profil.",
    },

    {
        icon: "ki-filled ki-chart-line-star",
        title: "Activités du compte",
        component: markRaw(Activities),
        props: { paginated: props.account_activities },
        description:
            "Consulte l'historique des activités et surveille les accès à ton compte.",
    },
]);

onMounted(async () => {
    await userStore.fetchSessions().then(() =>
        items.value.push({
            icon: "ki-filled ki-desktop-mobile",
            title: "Appareils Connectés",
            component: markRaw(LogoutOtherBrowserSessionsForm),
            props: { sessions: userStore.sessions },
            description:
                "Consulte et gère les appareils connectés à ton compte.",
        }),
    );
});
</script>
