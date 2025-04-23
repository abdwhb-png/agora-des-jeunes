import { defineStore, acceptHMRUpdate } from "pinia";
import { useAxios } from "@/composables/useAxios"; // Import useAxios

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
            const { fetchData } = useAxios();
            const usersData = await fetchData("/users");
            if(usersData) {
                this.users = usersData;
            }
        },

        async fetchManagers() {
            const { fetchData } = useAxios();
            const managersData = await fetchData("/managers");
            if(managersData) {
                this.managers = managersData;
            }
        },

        async fetchAdmins() {
            const { fetchData } = useAxios();
            const adminsData = await fetchData("/admins");
            if(adminsData) {
                this.admins = adminsData;
            }
        },
    },
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useUsersStore, import.meta.hot));
}
