<template>
    <Dialog
        v-model:visible="show"
        modal
        position="top"
        :closable="false"
        :style="{ width: '50rem' }"
        :breakpoints="dialogBreakpoints"
    >
        <slot>
            <NotAvailable />
        </slot>
    </Dialog>
</template>

<script setup>
import NotAvailable from "@/Components/Base/NotAvailable.vue";
import { dialogBreakpoints } from "@/utils/helpers";
import { onMounted, ref } from "vue";

const show = ref(false);
onMounted(() => {
    show.value = true;
});
</script>
