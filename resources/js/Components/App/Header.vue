<script setup lang="ts">
import DropdownNotification from "@/Components/Base/DropdownNotification.vue";
import DropdownUser from "@/Components/Base/DropdownUser.vue";
import Megamenu from "./Megamenu.vue";
</script>

<template>
    <header
        class="header fixed top-0 z-10 start-0 end-0 flex items-stretch shrink-0 bg-[--tw-page-bg] dark:bg-[--tw-page-bg-dark]"
        data-sticky="true"
        data-sticky-class="shadow-sm"
        data-sticky-name="header"
        id="header"
    >
        <!-- Container -->
        <div
            class="container-fixed flex justify-between items-stretch lg:gap-4"
            id="header_container"
        >
            <!-- Mobile Logo -->
            <div class="flex gap-1 lg:hidden items-center -ms-1">
                <a class="shrink-0" href="/">
                    <v-lazy-image
                        src="/images/favicon.png"
                        :alt="'Logo ' + $page.props.app.name"
                        class="max-h-[25px] w-full"
                    />
                </a>
                <div class="flex items-center">
                    <button
                        class="btn btn-icon btn-light btn-clear btn-sm"
                        data-drawer-toggle="#sidebar"
                    >
                        <i class="ki-filled ki-menu"> </i>
                    </button>
                    <button
                        class="btn btn-icon btn-light btn-clear btn-sm"
                        data-drawer-toggle="#mega_menu_wrapper"
                    >
                        <i class="ki-filled ki-burger-menu-2"> </i>
                    </button>
                </div>
            </div>
            <!-- End of Mobile Logo -->

            <!--Megamenu Contaoner-->
            <div class="flex items-stretch" id="mega_menu_container">
                <!--Megamenu Inner-->
                <div
                    class="flex items-stretch"
                    data-reparent="true"
                    data-reparent-mode="prepend|lg:prepend"
                    data-reparent-target="body|lg:#mega_menu_container"
                >
                    <!--Megamenu Wrapper-->
                    <Megamenu />
                    <!--End of Megamenu Wrapper-->
                </div>
                <!--End of Megamenu Inner-->
            </div>
            <!--End of Megamenu Container-->

            <!-- Topbar -->
            <div class="flex items-center gap-2 lg:gap-3.5">
                <button
                    class="btn btn-icon btn-icon-lg size-9 rounded-full hover:bg-primary-light hover:text-primary text-gray-500"
                    data-modal-toggle="#search_modal"
                >
                    <i class="ki-filled ki-magnifier"> </i>
                </button>
                <DropdownNotification />
                <DropdownUser
                    data-menu-item-offset="20px, 10px"
                    data-menu-item-offset-rtl="-20px, 10px"
                    data-menu-item-placement="bottom-end"
                    data-menu-item-placement-rtl="bottom-start"
                    data-menu-item-toggle="dropdown"
                    data-menu-item-trigger="click|lg:click"
                />
            </div>
            <!-- End of Topbar -->
        </div>
        <!-- End of Container -->
    </header>
</template>
