<script setup>
import TermsLayout from "@/Layouts/TermsLayout.vue";

defineProps({
    policy: String,
});
const description = `Bienvenue sur **site_name** ! La protection de tes données personnelles est essentielle pour nous.
<br>
Cette politique de confidentialité explique quelles informations nous collectons, comment nous les utilisons et comment nous les protégeons.`;
</script>

<template>
    <TermsLayout
        title="Politique de confidentialité"
        :description="description"
        :content="policy"
    >
    </TermsLayout>
</template>
