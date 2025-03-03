<script setup>
import TermsLayout from "@/Layouts/TermsLayout.vue";

defineProps({
    terms: String,
});
const description = `Bienvenue sur **site_name**, une plateforme conçue pour accompagner les jeunes dans leur développement personnel, professionnel et citoyen.
<br>
En utilisant notre site, tu acceptes les présentes **Conditions Générales d’Utilisation (CGU)**.`;
</script>

<template>
    <TermsLayout
        title="Conditions générales d'utilisation"
        :description="description"
        :content="terms"
    >
    </TermsLayout>
</template>
