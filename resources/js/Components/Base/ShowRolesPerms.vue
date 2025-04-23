<script setup>
import { ref } from "vue";
import { dialogBreakpoints, getIcon } from "@/utils";
import RolesPerms from "./RolesPerms.vue";

const show = ref(false);
</script>

<template>
    <a class="menu-link" href="javascript:void(0);" @click="show = true">
        <span class="menu-icon">
            <i :class="getIcon('role')"> </i>
        </span>
        <span class="menu-title"> Roles & Permissions </span>
    </a>

    <Dialog
        v-model:visible="show"
        modal
        dismissable-mask=""
        header="Roles & Permissions"
        :style="{ width: '50rem' }"
        :breakpoints="dialogBreakpoints"
    >
        <RolesPerms />
    </Dialog>
</template>
