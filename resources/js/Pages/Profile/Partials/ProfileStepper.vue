<template>
    <Tabs :default-value="stepValue" class="max-w-[400px]">
        <TabsList class="grid w-full grid-cols-2">
            <TabsTrigger
                v-for="item in items"
                :key="item.key"
                :value="item.key"
                >{{ item.title }}</TabsTrigger
            >
        </TabsList>
        <template v-for="item in items" :key="item.key">
            <TabsContent :value="item.key">
                <Card>
                    <CardHeader>
                        <CardTitle class="text-center">{{
                            item.title
                        }}</CardTitle>
                        <CardDescription class="text-center">{{
                            item.description
                        }}</CardDescription>
                        <CardContent class="my-2">
                            <component
                                :is="item.component"
                                class="grid gap-5 lg:py-7.5"
                                :user="user"
                            />
                        </CardContent>
                    </CardHeader>
                </Card>
            </TabsContent>
        </template>
    </Tabs>
</template>

<script setup>
import { markRaw } from "vue";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs";
import EditAddress from "./EditAddress.vue";
import EditPersonalInfo from "./EditPersonalInfo.vue";

defineProps({
    user: {
        type: Object,
        required: true,
    },
    stepValue: {
        type: String,
        default: "personal",
    },
});

const items = [
    {
        title: "Informations Personnelles",
        description: "Mise à jour des informations personnelles.",
        key: "personal",
        component: markRaw(EditPersonalInfo),
    },
    {
        title: "Adresse de résidence",
        description: "Mise à jour de l'adresse de résidence.",
        key: "residence",
        component: markRaw(EditAddress),
    },
];
</script>
