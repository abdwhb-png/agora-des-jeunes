import { FilterMatchMode } from "@primevue/core/api";

export const itemsPerPage = ["5", "10", "15", "20", "30", "50", "100"];

const baseFilters = {
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    status: { value: null, matchMode: FilterMatchMode.EQUALS },
};

export const scrollHeight = "550px";

export const pt = {
    table: { style: "min-width: 50rem" },
    column: {
        headerCell: (props) => ({
            class: "custom-header-class",
        }),
        bodycell: ({ state }) => ({
            class: "align-middle",
            style:
                state["d_editing"] &&
                "padding-top: 0.75rem; padding-bottom: 0.75rem",
        }),
    },
};
