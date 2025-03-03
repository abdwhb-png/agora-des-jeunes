<script setup>
import { ref } from "vue";
import { useDarkModeStore } from "@/stores/darkMode";
import { useLanguageStore } from "@/stores/language";
import { dialogBreakpoints, getIcon } from "@/utils/helpers";

import RolesPerms from "./RolesPerms.vue";
import EditProfilePhoto from "@/Pages/Profile/Partials/EditProfilePhoto.vue";

defineOptions({
    inheritAttrs: false,
});

defineProps({
    rounded: {
        type: Boolean,
        default: true,
    },
    imgSize: {
        type: String,
        default: "size-9",
    },
});

const { isDark, toggleDarkMode } = useDarkModeStore();
const { currentLanguage, languages, changeLanguage } = useLanguageStore();

const editProfilePic = ref(false);
const showRolesPerms = ref(false);
</script>

<template>
    <Dialog
        v-model:visible="editProfilePic"
        modal
        dismissable-mask=""
        header="Modifier la photo de profil"
        :style="{ width: '50rem' }"
        :breakpoints="dialogBreakpoints"
    >
        <EditProfilePhoto
            :user="$page.props.auth.user"
            @updated="editProfilePic = false"
        />
    </Dialog>

    <Dialog
        v-model:visible="showRolesPerms"
        modal
        dismissable-mask=""
        header="Roles & Permissions"
        :style="{ width: '50rem' }"
        :breakpoints="dialogBreakpoints"
    >
        <RolesPerms />
    </Dialog>

    <div class="menu" data-menu="true">
        <div class="menu-item menu-item-dropdown" v-bind="$attrs">
            <div
                class="menu-toggle btn btn-icon"
                :class="{ 'rounded-full': rounded, 'rounded-lg': !rounded }"
            >
                <img
                    alt=""
                    class="justify-center border border-gray-500 shrink-0"
                    :class="{
                        imgSize,
                        'rounded-full': rounded,
                        'rounded-lg': !rounded,
                    }"
                    :src="$page.props.auth.user.profile_photo_url"
                />
            </div>
            <div
                class="menu-dropdown menu-default light:border-gray-300 w-screen max-w-[250px]"
            >
                <div class="relative">
                    <button
                        class="absolute end-3 top-0 btn btn-icon btn-sm"
                        data-menu-dismiss="true"
                    >
                        <i class="pi pi-times"></i>
                    </button>
                </div>
                <div
                    class="flex items-center justify-between px-5 py-1.5 gap-1.5"
                >
                    <div class="flex items-center gap-2">
                        <img
                            alt=""
                            class="size-9 rounded-full border-2 border-success"
                            :src="$page.props.auth.user.profile_photo_url"
                        />
                        <div class="flex flex-col gap-1.5">
                            <span
                                class="text-sm text-gray-800 font-semibold leading-none"
                            >
                                {{ $page.props.auth.user.info.full_name }}
                            </span>
                            <a
                                class="text-xs text-gray-600 hover:text-primary font-medium leading-none"
                                href="#"
                            >
                                {{ $page.props.auth.user.email }}
                            </a>

                            <span
                                class="text-xs flex items-center gap-1"
                                :class="
                                    $page.props.auth.user.email_verified_at
                                        ? 'text-success'
                                        : 'text-danger'
                                "
                            >
                                <i
                                    class="ki-filled"
                                    :class="
                                        $page.props.auth.user.email_verified_at
                                            ? 'ki-verify'
                                            : 'ki-shield-cross'
                                    "
                                ></i>
                                email
                                {{
                                    $page.props.auth.user.email_verified_at
                                        ? "vérifié"
                                        : "non vérifié"
                                }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="menu-separator"></div>
                <div class="flex flex-col">
                    <div class="menu-item">
                        <a
                            class="menu-link"
                            href="javascript:void(0);"
                            @click="editProfilePic = true"
                        >
                            <span class="menu-icon">
                                <i :class="getIcon('profile_pic')"> </i>
                            </span>
                            <span class="menu-title"> Ma photo de profil </span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <Link class="menu-link" :href="route('profile.show')">
                            <span class="menu-icon">
                                <i :class="getIcon('profile')"> </i>
                            </span>
                            <span class="menu-title"> Mes informations </span>
                        </Link>
                    </div>
                    <div class="menu-item" v-if="$page.props.app.env = 'local'">
                        <a
                            class="menu-link"
                            href="javascript:void(0);"
                            @click="showRolesPerms = true"
                        >
                            <span class="menu-icon">
                                <i :class="getIcon('role')"> </i>
                            </span>
                            <span class="menu-title">
                                Roles & Permissions
                            </span>
                        </a>
                    </div>
                    <div
                        class="menu-item menu-item-dropdown"
                        data-menu-item-offset="-10px, 0"
                        data-menu-item-placement="left-start"
                        data-menu-item-toggle="dropdown"
                        data-menu-item-trigger="click|lg:hover"
                    >
                        <div class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-filled ki-icon"> </i>
                            </span>
                            <span class="menu-title"> Langage </span>
                            <div
                                class="flex items-center gap-1.5 rounded-md border border-gray-300 text-gray-600 p-1.5 text-2xs font-medium shrink-0"
                            >
                                {{ currentLanguage.name }}
                                <img
                                    alt=""
                                    class="inline-block size-3.5 rounded-full"
                                    :src="currentLanguage.flag"
                                />
                            </div>
                        </div>
                        <div
                            class="menu-dropdown menu-default light:border-gray-300 w-full max-w-[170px]"
                        >
                            <div
                                v-for="(item, index) in languages"
                                :key="index"
                                class="menu-item"
                                :class="{
                                    active: item.code === currentLanguage.code,
                                }"
                            >
                                <a
                                    class="menu-link h-10"
                                    href="#"
                                    @click="changeLanguage(item)"
                                >
                                    <span class="menu-icon">
                                        <img
                                            alt=""
                                            class="inline-block size-4 rounded-full"
                                            :src="item.flag"
                                        />
                                    </span>
                                    <span class="menu-title">
                                        {{ item.name }}
                                    </span>
                                    <span
                                        v-if="
                                            item.code === currentLanguage.code
                                        "
                                        class="menu-badge"
                                    >
                                        <i
                                            class="ki-solid ki-check-circle text-success text-base"
                                        >
                                        </i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-separator"></div>
                <div class="flex flex-col">
                    <div class="menu-item mb-0.5">
                        <div class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-filled ki-moon"> </i>
                            </span>
                            <span class="menu-title"> Mode Sombre </span>
                            <label class="switch switch-sm">
                                <input
                                    data-theme-state="dark"
                                    data-theme-toggle="true"
                                    name="check"
                                    type="checkbox"
                                    value="1"
                                    @change="toggleDarkMode"
                                    :checked="isDark"
                                />
                            </label>
                        </div>
                    </div>
                    <div class="menu-item px-4 py-1.5" data-menu-dismiss="true">
                        <Link
                            class="btn btn-sm btn-light justify-center"
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            <i class="pi pi-power-off" style="color: red"></i>
                            Déconnexion
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
