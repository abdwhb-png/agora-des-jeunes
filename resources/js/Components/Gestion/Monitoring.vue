<script setup></script>

<template>
    <!-- Monitoring Dropdown -->
    <div class="menu menu-default p-0 px-2" data-menu="true">
        <div
            class="menu-item w-full px-0.5 menu-item-dropdown"
            data-menu-item-offset="-4px, 0"
            data-menu-item-placement="top-start"
            data-menu-item-toggle="dropdown"
            data-menu-item-trigger="hover"
        >
            <button
                class="menu-toggle w-full btn btn-light btn-sm justify-between flex-nowrap"
            >
                <span class="flex items-center gap-1.5">
                    <i class="pi pi-external-link !text-md"> </i>
                    Monitoring
                </span>
                <span class="flex items-center lg:ms-4">
                    <i class="ki-filled ki-down !text-xs"> </i>
                </span>
            </button>
            <div class="menu-dropdown w-[150px] py-2" style="">
                <div class="menu-item">
                    <a class="menu-link" href="/pulse" target="_blank">
                        <span class="menu-icon">
                            <i class="ki-filled ki-pulse"> </i>
                        </span>
                        <span class="menu-title"> Pulse </span>
                    </a>
                    <a class="menu-link" href="/telescope" target="_blank">
                        <span class="menu-icon">
                            <i class="ki-filled ki-chart-line-star"> </i>
                        </span>
                        <span class="menu-title"> Telescope </span>
                    </a>
                    <a
                        class="menu-link"
                        :href="$apiManagerUrl || route('api-tokens.index')"
                        target="_blank"
                    >
                        <span class="menu-icon">
                            <i class="ki-filled ki-code"> </i>
                        </span>
                        <span class="menu-title"> API Manager </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Monitoring Dropdown -->
</template>
