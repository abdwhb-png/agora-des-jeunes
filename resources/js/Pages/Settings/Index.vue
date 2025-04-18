<template>
    <MainLayout title="Paramètres">
        <div class="flex grow gap-5 lg:gap-7.5">
            <div class="hidden lg:block w-[230px] shrink-0">
                <SettingsSide />
            </div>
            <div class="flex flex-col items-stretch grow gap-5 lg:gap-7.5">
                <Authentification
                    :user="$page.props.auth.user"
                    :confirms-two-factor-authentication="
                        confirmsTwoFactorAuthentication
                    "
                />
                <SectionBorder />
                <Activities :account-activities="account_activities" />
                <SectionBorder />
                <Others :user="$page.props.auth.user" />
                <SectionBorder />
                <DeactivateAccount />
                <SectionBorder />
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import SettingsSide from "./Partials/Side.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import DeactivateAccount from "./Partials/DeactivateAccount.vue";
import Authentification from "./Partials/Authentification.vue";
import Activities from "./Partials/Activities.vue";
import Others from "./Partials/Others.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    account_activities: Object,
});
</script>
