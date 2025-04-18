// External Libraries
import { Head, Link } from "@inertiajs/vue3";
import VLazyImage from "v-lazy-image";

// Layouts
import AuthLayout from "@/Layouts/AuthLayout.vue";
import ErrorLayout from "@/Layouts/ErrorLayout.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import PageLayout from "@/Layouts/PageLayout.vue";

// Base Components
import GlobalSearch from "@/Components/Shared/Search/GlobalSearch.vue";
import FormButtonGroup from "@/Components/Base/FormButtonGroup.vue";
import Loader from "@/Components/Base/Loader.vue";
import Notice from "@/Components/Base/Notice.vue";
import NotPermitted from "@/Components/Base/NotPermitted.vue";
import ToastError from "@/Components/Base/Toast/ValidationError.vue";
import ToastStatus from "@/Components/Base/Toast/Status.vue";

// UI Components
import BtnLink from "@/Components/Home/BtnLink.vue";
import CardTemplate from "@/Components/CardTemplate.vue";
import CopyBtn from "@/Components/CopyBtn.vue";
import InputError from "@/Components/InputError.vue";
import SearchInput from "@/Components/Shared/Search/SearchInput.vue";
import UiButton from "@/Components/ui/button/Button.vue";

// Table Components
import CustomDataTable from "@/Components/Tables/CustomDataTable.vue";
import Pagination from "@/Components/Tables/Pagination.vue";

// Icons
import ShapeIcon from "@/Components/Shared/Icons/Shape.vue";
import StarsIcon from "@/Components/Shared/Icons/Stars.vue";
import SubtitleIcon from "@/Components/Shared/Icons/Subtitle.vue";

// Image Components
import OptImg from "@/Components/Shared/OptimizedPublicImage.vue";

export default function registerComponents(app) {
    // External Libraries
    app.component("Head", Head);
    app.component("Link", Link);
    app.component("v-lazy-image", VLazyImage);

    // Layouts
    app.component("AuthLayout", AuthLayout);
    app.component("ErrorLayout", ErrorLayout);
    app.component("MainLayout", MainLayout);
    app.component("PageLayout", PageLayout);

    // Base Components
    app.component("GlobalSearch", GlobalSearch);
    app.component("FormButtonGroup", FormButtonGroup);
    app.component("Loader", Loader);
    app.component("Notice", Notice);
    app.component("NotPermitted", NotPermitted);
    app.component("ToastError", ToastError);
    app.component("ToastStatus", ToastStatus);

    // UI Components
    app.component("BtnLink", BtnLink);
    app.component("CardTemplate", CardTemplate);
    app.component("CopyBtn", CopyBtn);
    app.component("InputError", InputError);
    app.component("SearchInput", SearchInput);
    app.component("UiButton", UiButton);

    // Table Components
    app.component("CustomDataTable", CustomDataTable);
    app.component("Pagination", Pagination);

    // Icons
    app.component("ShapeIcon", ShapeIcon);
    app.component("StarsIcon", StarsIcon);
    app.component("SubtitleIcon", SubtitleIcon);

    // Image Components
    app.component("OptImg", OptImg);
}
