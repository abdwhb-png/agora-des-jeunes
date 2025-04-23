<template>
    <Tabs :default-value="stepValue" class="w-auto">
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
                            <component :is="item.component" :user="user" />
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
import EditPermissions from "./EditPermissions.vue";
import EditRoles from "./EditRoles.vue";

defineProps({
    user: {
        type: Object,
        required: true,
    },
    stepValue: {
        type: String,
        default: "roles",
    },
});

const items = [
    {
        title: "Roles",
        description: "Met à jour les rôles de l'utilisateur.",
        key: "roles",
        component: markRaw(EditRoles),
    },
    {
        title: "Permissions directes",
        description: "Met à jour les permissions directes de l'utilisateur.",
        key: "permissions",
        component: markRaw(EditPermissions),
    },
];
</script>
