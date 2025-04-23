<script setup lang="ts">
import { ref, markRaw, reactive, computed } from "vue";
import type { DefineComponent } from "vue";
import { dialogBreakpoints } from "@/utils";
import { MENU_CONFIGS } from "@/constants";
import type { MenuItem } from "primevue/menuitem";
import CreatePanel from "@/Components/Gestion/CreatePanel.vue";

type VueComponent = DefineComponent<any, any, any>;

type ComponentWithProps = {
    component: VueComponent | null;
    props: Record<string, any>;
};

const visible = ref(false);
const loading = ref(false);
const error = ref<string | null>(null);
const theComponent = ref<VueComponent | null>(null);

const createItem = reactive<ComponentWithProps>({
    component: null,
    props: {},
});

const listItem = reactive<ComponentWithProps>({
    component: null,
    props: {},
});

const onHide = () => {
    theComponent.value = null;
    error.value = null;
};

const dialogProps = computed(() => ({
    header: "Terminal de bord",
    breakpoints: dialogBreakpoints,
    style: { width: "100vw" },
    modal: true,
    position: "top" as const,
    dismissableMask: true,
    maximizable: true,
}));

const showDialog = async (component: VueComponent) => {
    loading.value = true;
    error.value = null;

    try {
        theComponent.value = markRaw(component || null);
        visible.value = true;
    } catch (err) {
        error.value = "Erreur lors du chargement du composant";
        console.error("Failed to display component:", err);
    } finally {
        loading.value = false;
    }
};

const displayComponent = async (
    create: ComponentWithProps,
    list: ComponentWithProps,
) => {
    loading.value = true;
    error.value = null;

    try {
        createItem.component = markRaw(create.component || null);
        createItem.props = create.props || {};
        listItem.component = markRaw(list.component || null);
        listItem.props = list.props || {};
        visible.value = true;
    } catch (err) {
        error.value = "Erreur lors du chargement des composants";
        console.error("Failed to display components:", err);
    } finally {
        loading.value = false;
    }
};

const createMenuItem = (
    label: string,
    configKey: keyof typeof MENU_CONFIGS,
): MenuItem => ({
    label,
    command: () => {
        const config = MENU_CONFIGS[configKey];
        return displayComponent(
            {
                component: config.formComponent,
                props: {
                    title: config.title,
                    description: config.description,
                    btnText: config.btnText,
                    image: config.image,
                },
            },
            {
                component: config.listComponent,
                props: {},
            },
        );
    },
});

const menuItems = [
    createMenuItem("Sessions d'Agora", "AGORA"),
    createMenuItem("Sondages", "POLLS"),
    createMenuItem("FAQs", "FAQS"),
    createMenuItem("Formations", "TRAININGS"),
    createMenuItem("Offres d'emploi", "JOB_OFFERS"),
];

const items = ref<MenuItem[]>([...menuItems]);
</script>

<template>
    <div class="card mx-3 my-2">
        <MegaMenu :model="items" />

        <Dialog v-model:visible="visible" v-bind="dialogProps" @hide="onHide">
            <template v-if="loading">
                <div class="flex justify-center p-4">
                    <i class="pi pi-spin pi-spinner text-2xl"></i>
                </div>
            </template>

            <template v-else-if="error">
                <div class="p-4 text-red-500">
                    {{ error }}
                </div>
            </template>

            <template v-else>
                <component v-if="theComponent" :is="theComponent" />
                <template v-else>
                    <CreatePanel
                        v-bind="createItem.props"
                        :create-component="createItem.component"
                    />
                    <Divider />
                    <component
                        :is="listItem.component"
                        v-bind="listItem.props"
                    />
                </template>
            </template>
        </Dialog>
    </div>
</template>
