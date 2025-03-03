import { defineStore, acceptHMRUpdate } from "pinia";
import { useApi } from "@/composables/useApi";

const { api } = useApi();

export const useUsersStore = defineStore("usersStore", {
    state: () => ({
        users: [],
        managers: [],
        admins: [],
        item: null,
    }),

    getters: {
        getUser:
            (state) =>
            (id = null) => {
                return id
                    ? state.list.find((user) => user.id == id)
                    : state.item;
            },
    },

    actions: {
        async setUser(item) {
            this.item = item;
        },

        async fetchUsers() {
            await api
                .get("/users")
                .then((response) => {
                    this.users = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async fetchManagers() {
            await api
                .get("/managers")
                .then((response) => {
                    this.users = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async fetchAdmins() {
            await api
                .get("/admins")
                .then((response) => {
                    this.admins = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUsersStore, import.meta.hot));
}
