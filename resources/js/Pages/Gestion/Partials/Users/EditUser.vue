<script setup>
import { useToast } from "primevue";
import { onMounted, ref } from "vue";

import ProfileStepper from "@/Pages/Profile/Partials/ProfileStepper.vue";
import RolesStepper from "./RolesStepper.vue";

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
});

const toast = useToast();

const user = ref(null);
const loading = ref(false);

onMounted(() => {
    getUser(props.id);
});

async function getUser(id) {
    loading.value = true;
    const url = route("user.show", id);
    await axios
        .get(url)
        .then((response) => {
            user.value = response.data;
        })
        .catch((error) => {
            console.log("Error while fetching user", error);
            toast.add({
                severity: "error",
                summary: "Erreur",
                detail: "Une erreur s'est produite lors du chargement de l'utilisateur.",
                life: 1000 * 10,
            });
        })
        .finally(() => {
            loading.value = false;
        });
}
</script>

<template>
    <Loader v-if="loading" />
    <div v-else-if="user">
        <Card>
            <template #title>
                {{ user.info.full_name || user.email }}
            </template>
            <template #content>
                <div class="grid md:grid-cols-2 justify-center gap-2">
                    <ProfileStepper :user="user" />
                    <RolesStepper :user="user" />
                </div>
            </template>
        </Card>
    </div>
</template>
