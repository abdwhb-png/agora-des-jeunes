<template>
    <div
        class="dropdown"
        data-dropdown="true"
        data-dropdown-offset="-10px, 15px"
        data-dropdown-placement="right-end"
        data-dropdown-trigger="click|lg:click"
    >
        <button
            class="dropdown-toggle btn btn-icon btn-icon-xl relative rounded-md size-9 border border-gray-500 hover:bg-light hover:text-primary hover:border-gray-200 dropdown-open:bg-gray-200 text-gray-600"
        >
            <span class="menu-icon">
                <i class="ki-filled ki-setting-4"> </i>
            </span>
        </button>
        <div
            class="dropdown-content light:border-gray-300 w-screen max-w-[320px]"
        >
            <div
                class="flex items-center justify-between gap-2.5 text-2xs text-gray-600 font-medium px-5 py-3 border-b border-b-gray-200"
            >
                <span> Apps </span>
                <span> Enabled </span>
            </div>
            <div
                class="flex flex-col scrollable-y-auto max-h-[400px] divide-y divide-gray-200"
            >
                <div
                    class="flex items-center justify-between flex-wrap gap-2 px-5 py-3.5"
                >
                    <div class="flex items-center flex-wrap gap-2">
                        <div
                            class="flex items-center justify-center shrink-0 rounded-full bg-gray-100 border border-gray-200 size-10"
                        >
                            <img
                                alt=""
                                class="size-6"
                                src="https://keenthemes.com/static/metronic/tailwind/dist/assets/media/brand-logos/jira.svg"
                            />
                        </div>
                        <div class="flex flex-col">
                            <a
                                class="text-2sm font-semibold text-gray-900 hover:text-primary-active"
                                href="#"
                            >
                                Jira
                            </a>
                            <span class="text-2xs font-medium text-gray-600">
                                Project management
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 lg:gap-5">
                        <label class="switch switch-sm">
                            <input type="checkbox" value="2" />
                        </label>
                    </div>
                </div>
                <div
                    class="flex items-center justify-between flex-wrap gap-2 px-5 py-3.5"
                >
                    <div class="flex items-center flex-wrap gap-2">
                        <div
                            class="flex items-center justify-center shrink-0 rounded-full bg-gray-100 border border-gray-200 size-10"
                        >
                            <img
                                alt=""
                                class="size-6"
                                src="https://keenthemes.com/static/metronic/tailwind/dist/assets/media/brand-logos/inferno.svg"
                            />
                        </div>
                        <div class="flex flex-col">
                            <a
                                class="text-2sm font-semibold text-gray-900 hover:text-primary-active"
                                href="#"
                            >
                                Inferno
                            </a>
                            <span class="text-2xs font-medium text-gray-600">
                                Ensures healthcare app
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 lg:gap-5">
                        <label class="switch switch-sm">
                            <input checked type="checkbox" value="1" />
                        </label>
                    </div>
                </div>
                <div
                    class="flex items-center justify-between flex-wrap gap-2 px-5 py-3.5"
                >
                    <div class="flex items-center flex-wrap gap-2">
                        <div
                            class="flex items-center justify-center shrink-0 rounded-full bg-gray-100 border border-gray-200 size-10"
                        >
                            <img
                                alt=""
                                class="size-6"
                                src="https://keenthemes.com/static/metronic/tailwind/dist/assets/media/brand-logos/evernote.svg"
                            />
                        </div>
                        <div class="flex flex-col">
                            <a
                                class="text-2sm font-semibold text-gray-900 hover:text-primary-active"
                                href="#"
                            >
                                Evernote
                            </a>
                            <span class="text-2xs font-medium text-gray-600">
                                Notes management app
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 lg:gap-5">
                        <label class="switch switch-sm">
                            <input checked type="checkbox" value="1" />
                        </label>
                    </div>
                </div>
                <div
                    class="flex items-center justify-between flex-wrap gap-2 px-5 py-3.5"
                >
                    <div class="flex items-center flex-wrap gap-2">
                        <div
                            class="flex items-center justify-center shrink-0 rounded-full bg-gray-100 border border-gray-200 size-10"
                        >
                            <img
                                alt=""
                                class="size-6"
                                src="https://keenthemes.com/static/metronic/tailwind/dist/assets/media/brand-logos/gitlab.svg"
                            />
                        </div>
                        <div class="flex flex-col">
                            <a
                                class="text-2sm font-semibold text-gray-900 hover:text-primary-active"
                                href="#"
                            >
                                Gitlab
                            </a>
                            <span class="text-2xs font-medium text-gray-600">
                                DevOps platform
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 lg:gap-5">
                        <label class="switch switch-sm">
                            <input type="checkbox" value="2" />
                        </label>
                    </div>
                </div>
                <div
                    class="flex items-center justify-between flex-wrap gap-2 px-5 py-3.5"
                >
                    <div class="flex items-center flex-wrap gap-2">
                        <div
                            class="flex items-center justify-center shrink-0 rounded-full bg-gray-100 border border-gray-200 size-10"
                        >
                            <img
                                alt=""
                                class="size-6"
                                src="https://keenthemes.com/static/metronic/tailwind/dist/assets/media/brand-logos/google-webdev.svg"
                            />
                        </div>
                        <div class="flex flex-col">
                            <a
                                class="text-2sm font-semibold text-gray-900 hover:text-primary-active"
                                href="#"
                            >
                                Google webdev
                            </a>
                            <span class="text-2xs font-medium text-gray-600">
                                Building web expierences
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 lg:gap-5">
                        <label class="switch switch-sm">
                            <input checked type="checkbox" value="1" />
                        </label>
                    </div>
                </div>
            </div>
            <div class="grid p-5 border-t border-t-gray-200">
                <a
                    class="btn btn-sm btn-light justify-center"
                    href="account/api-keys.html"
                >
                    Go to Apps
                </a>
            </div>
        </div>
    </div>
</template>
