<template>
    <MainLayout title="Paramètres">
        <div class="flex grow gap-5 lg:gap-7.5">
            <div class="hidden lg:block w-[230px] shrink-0">
                <SettingsSide />
            </div>
            <div class="flex flex-col items-stretch grow gap-5 lg:gap-7.5">
                <AuthSetting
                    :user="$page.props.auth.user"
                    :confirms-two-factor-authentication="
                        confirmsTwoFactorAuthentication
                    "
                />
                <SectionBorder />
                <AccountSetting :user="$page.props.auth.user" />
                <SectionBorder />
                <DeactivateAccount />
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import SettingsSide from "./Partials/Side.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import DeactivateAccount from "./Partials/DeactivateAccount.vue";
import AuthSetting from "./Partials/AuthSetting.vue";
import AccountSetting from "./Partials/AccountSetting.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>
