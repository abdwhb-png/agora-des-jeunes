<script setup>
import { ref, markRaw } from "vue";

const visible = ref(false);
const currentComponent = ref(null);
const componentProps = ref({});

const displayComponent = (component, props = {}) => {
    currentComponent.value = markRaw(component);
    componentProps.value = props;
    visible.value = true;
};

const items = ref([
    {
        label: "Sessions Agora",
        icon: "/gestion/images/presentation.png",
        command: () => {},
    },
    {
        label: "Sondages",
        icon: "/gestion/images/vote.png",
        command: () => {},
    },
    {
        label: "Foire aux Questions",
        icon: "/gestion/images/faq.png",
        command: () => {},
    },
    {
        label: "Formations",
        icon: "https://primefaces.org/cdn/primevue//images/dock/safari.svg",
        command: () => {},
    },
    {
        label: "Offres d'Emplois",
        icon: "https://primefaces.org/cdn/primevue//images/dock/photos.svg",
        command: () => {},
    },
]);
</script>
<template>
    <div class="dock-window dock-advanced fixed top-0 right-0 h-[100vh]">
        <Dock :model="items" :position="'right'">
            <template #item="{ item }">
                <a
                    v-tooltip.top="item.label"
                    href="#"
                    class="p-dock-item-link"
                    @click="onDockItemClick($event, item)"
                >
                    <img
                        :alt="item.label"
                        :src="item.icon"
                        style="width: 100%"
                    />
                </a>
            </template>
        </Dock>

        <Dialog
            v-model:visible="visible"
            header="Terminal"
            :breakpoints="{ '960px': '50vw' }"
            :style="{ width: '100vw' }"
            modal
            :maximizable="true"
        >
            <component :is="currentComponent" v-bind="componentProps" />
        </Dialog>
    </div>
</template>

<style scoped>
.dock-window > .p-dock {
    z-index: 1000;
    background-image: url("https://primefaces.org/cdn/primevue/images/dock/window.jpg");
    @apply px-2 bg-cover bg-no-repeat;
}
.dock-window {
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
