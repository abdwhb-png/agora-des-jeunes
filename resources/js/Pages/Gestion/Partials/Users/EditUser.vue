<script setup>
import { useToast } from "primevue";
import { onMounted, ref } from "vue";

import ProfileStepper from "@/Pages/Profile/Partials/ProfileStepper.vue";
import EditRoles from "./EditRoles.vue";
import EditPermissions from "./EditPermissions.vue";

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
                life: 1000 * 30,
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
                <div class="grid md:grid-cols-2 gap-2">
                    <ProfileStepper :user="user" />
                    <Stepper>
                        <StepItem value="3">
                            <Step>Roles</Step>
                            <StepPanel>
                                <EditRoles :user="user" />
                            </StepPanel>
                        </StepItem>
                        <StepItem value="4">
                            <Step>Permissions Directes</Step>
                            <StepPanel>
                                <EditPermissions :user="user" />
                            </StepPanel>
                        </StepItem>
                    </Stepper>
                </div>
            </template>
        </Card>
    </div>
</template>
