<template>
    <Stepper :value="stepValue">
        <StepItem value="1">
            <Step>Informations Personnelles</Step>
            <StepPanel>
                <EditPersonalInfo
                    :user="user"
                    class="card-body grid gap-5 lg:py-7.5 px-0"
                />
            </StepPanel>
        </StepItem>
        <StepItem value="2">
            <Step>Adresse de résidence</Step>
            <StepPanel>
                <EditAddress
                    :user="user"
                    class="card-body grid gap-5 lg:py-7.5 px-0"
                />
            </StepPanel>
        </StepItem>
    </Stepper>
</template>

<script setup>
import EditAddress from "./EditAddress.vue";
import EditPersonalInfo from "./EditPersonalInfo.vue";

defineProps({
    user: {
        type: Object,
        required: true,
    },
    stepValue: {
        type: String,
        default: "1",
    },
});
</script>
