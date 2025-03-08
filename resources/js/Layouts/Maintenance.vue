<template>
    <Dialog
        v-model:visible="show"
        modal
        position="top"
        @hide="$inertia.visit(route('dashboard'))"
        :style="{ width: '50rem' }"
        :breakpoints="dialogBreakpoints"
        pt:root:class="!border-0 !bg-transparent"
        pt:mask:class="backdrop-blur-sm"
    >
        <template #container="{ closeCallback }">
            <div
                class="flex flex-col px-8 py-8 gap-6 rounded-2xl"
                :class="[
                    'bg-[radial-gradient(circle_at_left_top,var(--p-primary-50),var(--p-primary-400))]',
                ]"
            >
                <slot>
                    <NotAvailable />
                </slot>
            </div>
        </template>
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
