import { defineStore, acceptHMRUpdate } from "pinia";
import { usePage } from "@inertiajs/vue3";
import { useApi } from "@/composables/useApi";
import { Role, Permission } from "@/types";

const api = useApi();
const page = usePage();

export const useUserStore = defineStore("userStore", {
    state: () => ({
        user: null,
        permissions: [],
        roles: [],
        sessions: [],
        notifications: [],
        unreadNotif: null,
    }),

    getters: {
        getNotifications: (state) => {
            return (key: string = "all") => {
                try {
                    return state.notifications[key];
                } catch (error) {
                    return [];
                }
            };
        },
        getUnreadNotif: (state) => state.unreadNotif || 0,
        hasPermission:
            (state) =>
            (name: string): boolean => {
                const allPermissions = state.permissions.all || [];
                const viaRolesPermissions = state.permissions.via_roles || [];
                const direct = state.permissions.direct || [];

                return [
                    ...allPermissions,
                    ...viaRolesPermissions,
                    ...direct,
                ].some((permission: Permission) => permission.name === name);
            },
        hasRole:
            (state) =>
            (name: string): boolean => {
                return state.roles.find((role: Role) => role.name === name)
                    ? true
                    : false;
            },
    },

    actions: {
        async fetchUser() {
            axios
                .get(route("user.me"))
                .then((response) => {
                    this.user = response.data;
                })
                .catch((error) => {
                    console.log("Error while fetching user", error);
                });

            this.fetchPermissions();
            this.fetchRoles();
        },

        async fetchNotifications() {
            await axios
                .get(route("user.notifications"))
                .then((response) => {
                    const { unread_count, notifications } = response.data;
                    this.notifications = notifications;
                    this.unreadNotif = unread_count;
                })
                .catch((error) => {
                    console.log(
                        "Error while fetching user notifications",
                        error,
                    );
                });
        },

        async fetchPermissions() {
            await axios
                .get(route("user.permissions"))
                .then((response) => {
                    this.permissions = response.data;
                })
                .catch((error) => {
                    console.log("Error while fetching user permissions", error);
                });
        },

        async fetchRoles() {
            await axios
                .get(route("user.roles"))
                .then((response) => {
                    this.roles = response.data;
                })
                .catch((error) => {
                    console.log("Error while fetching user roles", error);
                });
        },

        async fetchSessions() {
            await axios
                .get(route("user.sessions"))
                .then((response) => {
                    this.sessions = response.data;
                })
                .catch((error) => {
                    console.log("Error while fetching user sessions", error);
                });
        },
    },
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot));
}
