<script setup>
import { ref } from "vue";

const props = defineProps({
    data: { type: Object, default: null },
});

const lastAvatarValue = ref(
    props.data?.today_count - props.data?.show_today.length,
);
</script>
<template>
    <div
        class="card flex-col justify-between gap-6 h-full bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg"
    >
        <div class="card-body" v-if="data">
            <div class="flex flex-col justify-center gap-4">
                <h2 class="text-1.5xl font-semibold text-gray-900">
                    <span class="link">{{ data.members_count }}</span>
                    membres uniques
                </h2>
                <p class="text-sm font-normal text-gray-700 leading-5.5">
                    Inscrits aujourd'hui
                </p>
                <AvatarGroup v-if="data.show_today.length">
                    <Avatar
                        v-for="(user, index) in data.show_today"
                        :key="user.id"
                        :image="user.profile_photo_url"
                        shape="circle"
                    />
                    <Avatar
                        v-if="lastAvatarValue"
                        :label="'+' + lastAvatarValue"
                        shape="circle"
                    />
                </AvatarGroup>
                <Message v-else severity="secondary">
                    Aucun membre inscrit aujourd'hui
                </Message>
            </div>
        </div>
        <div class="card-footer justify-center">
            <Link
                class="btn btn-link"
                :href="route($page.props.routePrefix + 'users')"
            >
                Voir toute la liste
            </Link>
        </div>
    </div>
</template>
