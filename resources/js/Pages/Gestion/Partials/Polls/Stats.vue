<template>
    <Loader v-if="loading" />
    <Card v-else>
        <template #content>
            <div class="flex justify-center"></div>
        </template>
    </Card>
</template>

<script>
export default {
    name: "PollStats",
};
</script>

<script setup>
import { usePage } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { useToast } from "primevue";

const page = usePage();
const toast = useToast();

const data = ref([]);
const loading = ref(false);

onMounted(() => {
    getData();
});

async function getData() {
    const url = route(page.props.routePrefix + "polls.stats");
    loading.value = true;
    await axios
        .get(url)
        .then((response) => {
            data.value = response.results;
        })
        .catch((error) => {
            console.log("Error while fetching polls stats", error);
            toast.add({
                severity: "error",
                summary: "Erreur",
                detail: "Une erreur s'est produite lors du chargement des statistiques de sondages.",
                life: 1000 * 30,
            });
        })
        .finally(() => {
            loading.value = false;
        });
}
</script>
