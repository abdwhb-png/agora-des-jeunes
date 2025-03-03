<script setup>
import { useUserStore } from "@/stores/user";
import NotificationRepeater from "./NotificationRepeater.vue";
import { ref } from "vue";
import { useNotification } from "@/composables/useNotification";
import { useToast } from "primevue";

const userStore = useUserStore();
const toast = useToast();
const { readAll, archive } = useNotification(toast);

const loading = ref(false);
const items = ref([]);

const tabs = [
    {
        label: "Tout",
        value: "all",
    },
    {
        label: "Non Lus",
        value: "unread",
    },
    {
        label: "Lus",
        value: "read",
    },
];

const currentTab = ref(tabs[0]);

const changeTab = async (tab) => {
    loading.value = true;
    await userStore
        .fetchNotifications(tab.value)
        .then(() => {
            items.value = userStore.getNotifications(tab.value);
            currentTab.value = tab;
        })
        .finally(() => (loading.value = false));
};
</script>

<template>
    <div
        class="dropdown"
        data-dropdown="true"
        data-dropdown-offset="-10px, 10px"
        data-dropdown-placement="bottom-end"
        data-dropdown-placement-rtl="bottom-start"
        data-dropdown-trigger="click|lg:click"
    >
        <button
            @click="changeTab(tabs[0])"
            class="dropdown-toggle btn btn-icon btn-icon-lg size-9 rounded-md hover:bg-gray-200 dropdown-open:bg-gray-200 hover:text-primary text-gray-600"
        >
            <OverlayBadge severity="danger" v-if="userStore.unreadNotif">
                <i
                    class="ki-filled ki-notification-bing"
                    :data-count="userStore.getUnreadNotif"
                >
                </i>
            </OverlayBadge>
            <i v-else class="ki-filled ki-notification"> </i>
        </button>
        <div
            class="dropdown-content light:border-gray-300 w-full max-w-[460px]"
        >
            <div
                class="flex items-center justify-between gap-2.5 text-sm text-gray-900 font-semibold px-5 py-2.5 border-b border-b-gray-200"
                id="notifications_header"
            >
                Notifications
                <button
                    class="btn btn-sm btn-icon btn-light btn-clear shrink-0"
                    data-dropdown-dismiss="true"
                >
                    <i class="ki-filled ki-cross"> </i>
                </button>
            </div>
            <div
                class="tabs justify-between px-5 mb-2"
                data-tabs="true"
                id="notifications_tabs"
            >
                <div class="flex items-center gap-5">
                    <template v-for="(tab, index) in tabs" :key="tab.value">
                        <button
                            class="tab"
                            :class="{
                                active: currentTab.value == tab.value,
                                relative: tab.value == 'unread',
                            }"
                            :data-tab-toggle="`#notifications_tab_${tab.value}`"
                            @click="changeTab(tab)"
                        >
                            {{ tab.label }}
                            <span
                                v-if="
                                    tab.value == 'unread' &&
                                    userStore.unreadNotif
                                "
                                class="badge badge-dot badge-success size-[5px] absolute top-2 rtl:start-0 end-0 transform translate-y-1/2 translate-x-full"
                            >
                            </span>
                        </button>
                    </template>
                </div>
            </div>
            <template v-for="(tab, index) in tabs" :key="tab.value">
                <div
                    class="grow"
                    :class="{ hidden: tab.value != currentTab.value }"
                    :id="`notifications_tab_${tab.value}`"
                >
                    <div class="flex flex-col">
                        <div
                            class="scrollable-y-auto"
                            data-scrollable="true"
                            data-scrollable-dependencies="#header"
                            data-scrollable-max-height="auto"
                            data-scrollable-offset="200px"
                            style="max-height: 366px"
                        >
                            <Loader v-if="loading" />
                            <div
                                v-else
                                class="flex flex-col gap-5 pt-3 pb-4 divider-y divider-gray-200"
                            >
                                <template
                                    v-for="(item, index) in items"
                                    :key="item.id"
                                >
                                    <div
                                        v-if="index > 0"
                                        class="border-b border-b-gray-200"
                                    ></div>
                                    <NotificationRepeater :item="item" />
                                </template>

                                <div class="border-b border-b-gray-200"></div>
                            </div>
                        </div>
                        <div
                            class="grid grid-cols-2 p-5 gap-2.5"
                            :id="`#notifications_tab_${tab.value}_footer`"
                        >
                            <Button
                                class="btn btn-sm btn-light justify-center"
                                label="Tout archiver"
                                unstyled=""
                                :loading="loading"
                                @click="archive"
                            />
                            <Button
                                class="btn btn-sm btn-light justify-center"
                                label="Tout marqué comme lu"
                                unstyled=""
                                :loading="loading"
                                @click="readAll"
                            />
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
