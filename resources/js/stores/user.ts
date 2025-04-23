import { defineStore, acceptHMRUpdate } from "pinia";
import { Role, Permission } from "@/types";
import { useAxios } from "@/composables/useAxios"; // Import useAxios

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
                const allPermissions = (state.permissions as any).all || [];
                const viaRolesPermissions =
                    (state.permissions as any).via_roles || [];
                const direct = (state.permissions as any).direct || [];

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
            const { fetchData } = useAxios(); // Instantiate useAxios
            const userData = await fetchData(route("user.me"), {
                errorMessage: "Erreur lors de la récupération de l'utilisateur",
            });

            if (userData) {
                this.user = userData;
                // Fetch related data only if user fetch was successful
                this.fetchPermissions();
                this.fetchRoles();
            }
        },

        async fetchNotifications() {
            const { fetchData } = useAxios<{
                unread_count: number;
                notifications: any[];
            }>();
            const notificationData = await fetchData(
                route("user.notifications"),
                {
                    errorMessage:
                        "Erreur lors de la récupération des notifications",
                },
            );

            if (notificationData) {
                this.notifications = notificationData.notifications;
                this.unreadNotif = notificationData.unread_count;
            }
        },

        async fetchPermissions() {
            const { fetchData } = useAxios();
            const permissionData = await fetchData(route("user.permissions"), {
                errorMessage: "Erreur lors de la récupération des permissions",
            });

            if (permissionData) {
                this.permissions = permissionData;
            }
        },

        async fetchRoles() {
            const { fetchData } = useAxios();
            const roleData = await fetchData(route("user.roles"), {
                errorMessage: "Erreur lors de la récupération des rôles",
            });

            if (roleData) {
                this.roles = roleData;
            }
        },

        async fetchSessions() {
            const { fetchData } = useAxios();
            const sessionData = await fetchData(route("user.sessions"), {
                errorMessage: "Erreur lors de la récupération des sessions",
            });

            if (sessionData) {
                this.sessions = sessionData;
            }
        },
    },
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUserStore, import.meta.hot));
}
