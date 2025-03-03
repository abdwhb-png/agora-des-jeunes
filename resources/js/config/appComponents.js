import { Head, Link } from "@inertiajs/vue3";

import MainLayout from "@/Layouts/MainLayout.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import ErrorLayout from "@/Layouts/ErrorLayout.vue";
import PageLayout from "@/Layouts/PageLayout.vue";
import InputError from "@/Components/InputError.vue";
import CardTemplate from "@/Components/CardTemplate.vue";
import CustomDataTable from "@/Components/Tables/CustomDataTable.vue";
import Pagination from "@/Components/Tables/Pagination.vue";
import Notice from "@/Components/Base/Notice.vue";
import Loader from "@/Components/Base/Loader.vue";
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";
import ToastError from "@/Components/Base/Toast/ValidationError.vue";
import ToastStatus from "@/Components/Base/Toast/Status.vue";
import SearchInput from "@/Components/SearchInput.vue";
import CopyBtn from "@/Components/CopyBtn.vue";
import NotPermitted from "@/Components/Base/NotPermitted.vue";
import VLazyImage from "v-lazy-image";

export default function registerComponents(app) {
    app.component("Head", Head);
    app.component("Link", Link);

    app.component("MainLayout", MainLayout);
    app.component("AuthLayout", AuthLayout);
    app.component("ErrorLayout", ErrorLayout);
    app.component("PageLayout", PageLayout);

    app.component("InputError", InputError);
    app.component("Loader", Loader);

    app.component("NotPermitted", NotPermitted);
    app.component("CopyBtn", CopyBtn);
    app.component("SearchInput", SearchInput);
    app.component("CardTemplate", CardTemplate);
    app.component("CustomDataTable", CustomDataTable);
    app.component("Pagination", Pagination);
    app.component("Notice", Notice);
    app.component("FormButtonGroup", FormButtonGroup);
    app.component("ToastError", ToastError);
    app.component("ToastStatus", ToastStatus);

    app.component("v-lazy-image", VLazyImage);
}
