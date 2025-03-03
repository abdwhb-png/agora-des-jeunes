<template>
    <Drawer>
        <DrawerTrigger as-child>
            <UiButton variant="outline" size="icon">
                <i class="pi pi-search"></i>
            </UiButton>
        </DrawerTrigger>
        <DrawerContent>
            <div class="mx-auto w-full max-w-sm">
                <DrawerHeader>
                    <DrawerTitle>Recherche</DrawerTitle>
                    <DrawerDescription
                        >Rechercher une ressource du site.</DrawerDescription
                    >
                </DrawerHeader>
                <div class="p-4 pb-0">
                    <IconField>
                        <InputIcon class="pi pi-search" />
                        <InputText
                            placeholder="Entrer votre recherche"
                            fluid
                            v-model="input"
                        />
                    </IconField>
                </div>
                <DrawerFooter>
                    <UiButton>OK</UiButton>
                    <DrawerClose as-child>
                        <UiButton variant="secondary"> Annuler </UiButton>
                    </DrawerClose>
                </DrawerFooter>
            </div>
        </DrawerContent>
    </Drawer>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Button as UiButton } from "@/Components/ui/button";
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from "@/Components/ui/drawer";

const input = ref(null);
</script>
