<template>
    <button class="btn btn-sm btn-icon btn-clear btn-light" @click="onClick">
        <i class="ki-filled ki-notepad-edit"> </i>
    </button>
    <Dialog
        v-model:visible="edit"
        modal
        dismissable-mask
        maximizable
        :header="dialogHeader"
        :style="{ width: dialogWidth }"
        :breakpoints="dialogBreakpoints"
    >
        <component
            :is="editComponent"
            v-bind="componentProps"
            @updated="edit = false"
        />
    </Dialog>
</template>

<script setup>
import { dialogBreakpoints } from "@/utils/helpers";
import { ref } from "vue";

const emits = defineEmits(["clicked"]);

const props = defineProps({
    editComponent: {
        type: Object,
        default: null,
    },
    componentProps: {
        type: Object,
        default: null,
    },
    dialogHeader: {
        type: String,
        default: "Modifier un élément",
    },
    dialogWidth: {
        type: String,
        default: "50rem",
    },
    showDialog: {
        type: Boolean,
        default: true,
    },
});

const edit = ref(false);

const onClick = () => {
    if (props.showDialog) {
        edit.value = true;
    }

    emits("clicked");
};
</script>
