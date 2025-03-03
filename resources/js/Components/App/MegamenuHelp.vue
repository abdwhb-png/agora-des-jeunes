<template>
    <div
        class="menu-item"
        data-menu-item-offset="0,0|lg:-20px, 0"
        data-menu-item-offset-rtl="0,0|lg:20px, 0"
        data-menu-item-overflow="true"
        data-menu-item-placement="bottom-start"
        data-menu-item-placement-rtl="bottom-end"
        data-menu-item-toggle="dropdown"
        data-menu-item-trigger="click|lg:hover"
    >
        <div
            class="menu-link text-sm text-gray-700 font-medium menu-link-hover:text-primary menu-item-active:text-gray-900 menu-item-show:text-primary menu-item-here:text-gray-900 menu-item-active:font-semibold menu-item-here:font-semibold"
        >
            <span class="menu-title text-nowrap"> Besoin d'aide ? </span>
            <span class="menu-arrow flex lg:hidden">
                <i class="ki-filled ki-plus text-2xs menu-item-show:hidden">
                </i>
                <i
                    class="ki-filled ki-minus text-2xs hidden menu-item-show:inline-flex"
                >
                </i>
            </span>
        </div>

        <div
            class="menu-dropdown menu-default py-2.5 w-full max-w-[220px]"
            style=""
        >
            <div class="menu-item">
                <a class="menu-link" href="#" tabindex="0">
                    <span class="menu-icon">
                        <i class="ki-filled ki-questionnaire-tablet"> </i>
                    </span>
                    <span class="menu-title grow-0"> Par où commencer </span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link" href="#" tabindex="0">
                    <span class="menu-icon">
                        <i class="ki-filled ki-message-question"> </i>
                    </span>
                    <span class="menu-title grow-0"> Foire aux questions </span>
                </a>
            </div>
            <div class="menu-separator"></div>
            <div class="menu-item">
                <a
                    class="menu-link"
                    :href="
                        $page.props.config.contact_url ||
                        'mailto:' + $page.props.config.site_email
                    "
                    target="_blank"
                    tabindex="0"
                >
                    <span class="menu-icon">
                        <i class="ki-filled ki-message-text-2"> </i>
                    </span>
                    <span class="menu-title grow-0"> Nous Contacter </span>
                </a>
            </div>
        </div>
    </div>
</template>
