<template>
    <MainLayout title="Mon Compte">
        <ProfileOverview :user="$page.props.auth.user" />
        <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 lg:gap-7.5"
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
                dismissable-mask
                :header="currentItem?.title"
                :style="{ width: '50rem' }"
                :breakpoints="dialogBreakpoints"
            >
                <component
                    v-if="currentItem"
                    :is="currentItem.component"
                    :user="page.props.auth.user"
                    v-bind="currentItem?.props || {}"
                />
            </Dialog>
        </div>
    </MainLayout>
</template>

<script setup lang="ts">
import { router, usePage } from "@inertiajs/vue3";
import { markRaw, ref } from "vue";
import { dialogBreakpoints, getIcon } from "@/utils/helpers";

import EmailAndPassword from "./Partials/EmailAndPassword.vue";
import EditProfilePhoto from "@/Pages/Profile/Partials/EditProfilePhoto.vue";
import ProfileStepper from "@/Pages/Profile/Partials/ProfileStepper.vue";
import ProfileOverview from "./Partials/ProfileOverview.vue";

interface Item {
    icon: string;
    title: string;
    url?: string;
    component?: any;
    props?: Object;
    description?: string;
}

const page = usePage();

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
        icon: getIcon("profile_pic"),
        title: "Ma photo de profil",
        component: markRaw(EditProfilePhoto),
        description: "Met à jour ta photo de profil.",
    },
    {
        icon: getIcon("profile"),
        title: "À propos de moi",
        component: markRaw(ProfileStepper),
        description: "Gère tes informations personnelles.",
    },
    {
        icon: "ki-filled ki-security-user",
        title: "Email & Mot de passe",
        component: markRaw(EmailAndPassword),
        description: "Modifie ton email ou ton mot de passe.",
    },
    {
        icon: getIcon("settings"),
        title: "Paramètres du compte",
        url: route(page.props.routePrefix + "settings"),
        description: "Gère la sécurité de ton compte.",
    },
]);
</script>
