<template>
    <Loader v-if="loading" />
    <Card v-else-if="$page.props.app.env == 'local'">
        <template #content>
            <Stepper value="1">
                <StepItem value="1">
                    <Step>Roles ({{ userStore.roles.length }})</Step>
                    <StepPanel>
                        <div
                            class="flex flex-wrap justify-around items-center gap-2"
                        >
                            <Tag
                                v-for="item in userStore.roles"
                                :key="item.id"
                                severity="secondary"
                                :value="item.name"
                            />
                        </div>
                    </StepPanel>
                </StepItem>
                <StepItem value="2">
                    <Step
                        >Direct Permissions ({{
                            userStore.permissions.direct?.length
                        }})</Step
                    >
                    <StepPanel>
                        <PermsRepeater
                            :show-search="true"
                            :data="userStore.permissions.direct || []"
                        />
                    </StepPanel>
                </StepItem>
                <StepItem value="3">
                    <Step
                        >Permissions via Roles ({{
                            userStore.permissions.via_roles?.length
                        }})</Step
                    >
                    <StepPanel>
                        <PermsRepeater
                            :show-search="true"
                            :data="userStore.permissions.via_roles || []"
                        />
                    </StepPanel>
                </StepItem>
                <StepItem value="4">
                    <Step
                        >All Permissions ({{
                            userStore.permissions.all?.length
                        }})</Step
                    >
                    <StepPanel>
                        <PermsRepeater
                            :show-search="true"
                            :data="userStore.permissions.all || []"
                        />
                    </StepPanel>
                </StepItem>
            </Stepper>
        </template>
    </Card>
</template>

<script setup lang="ts">
import PermsRepeater from "@/Components/Permissions/Repeater.vue";
import { useUserStore } from "@/stores/user";
import { onMounted, ref } from "vue";

const userStore = useUserStore();
const loading = ref(false);

onMounted(async () => {
    loading.value = true;
    await userStore.fetchPermissions();
    await userStore.fetchRoles();
    loading.value = false;
});
</script>
