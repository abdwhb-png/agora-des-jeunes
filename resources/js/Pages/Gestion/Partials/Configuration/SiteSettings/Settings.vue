<template>
    <div class="grid lg:grid-cols-5 gap-5 lg:gap-7.5 items-stretch">
        <div class="lg:col-span-3">
            <SettingsForm :setting="data" />
        </div>

        <div class="lg:col-span-2">
            <OtherSettings />
        </div>
    </div>
</template>

<script setup>
import OtherSettings from "./OtherSettings.vue";
import SettingsForm from "./SettingsForm.vue";

const props = defineProps({
    site_settings: Object,
});

const { created_at, ...data } = props.site_settings;
</script>
