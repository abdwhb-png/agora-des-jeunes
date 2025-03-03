<script setup>
import { useUserStore } from "@/stores/user";
import RolesStats from "./RolesStats.vue";
import UsersStats from "./UsersStats.vue";

const userStore = useUserStore();
</script>

<template>
    <div class="card h-full">
        <div class="card-header">
            <h3 class="card-title">Statistiques</h3>
        </div>
        <div class="card-body flex flex-col gap-4 p-5 lg:p-7.5 lg:pt-4">
            <UsersStats :data="$page.props.users_stats" />
            <RolesStats :data="$page.props.roles_stats" />
            <div class="border-b border-gray-300"></div>
            <div class="grid gap-3">
                <div
                    v-for="(stat, index) in $page.props.stats"
                    :key="index"
                    class="flex items-center justify-between flex-wrap gap-2"
                >
                    <div class="flex items-center gap-1.5">
                        <i
                            v-if="stat.icon"
                            :class="
                                'text-base text-gray-500 ki-filled' + stat.icon
                            "
                        >
                        </i>
                        <span class="text-sm font-normal text-gray-900">
                            {{ index }}
                        </span>
                    </div>
                    <div
                        class="flex items-center text-sm font-medium text-gray-800 gap-6"
                    >
                        <Tag :value="stat.value" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
