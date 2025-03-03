<script setup>
import { useMainStore } from "@/stores/main";
import Logo from "@/Components/Logo.vue";
import HeaderNavRight from "./HeaderNavRight.vue";
import NavResources from "./NavResources.vue";

const mainStore = useMainStore();
</script>

<template>
    <div
        id="main-nav"
        data-animation="default"
        data-collapse="medium"
        data-duration="600"
        data-easing="ease"
        data-easing2="ease"
        role="banner"
        class="primary-nav w-nav"
    >
        <div class="primary-nav-contain">
            <a href="/" class="nav-brand w-nav-brand" aria-label="accueil">
                <Logo class="logo h-12 md:h-16" />
            </a>
            <nav
                role="navigation"
                class="nav-menu w-nav-menu"
                style="
                    transition: all;
                    transform: translateY(0px) translateX(0px);
                "
            >
                <div class="nav-menu-top-wrapper">
                    <a
                        href="/"
                        class="nav-brand w-nav-brand"
                        aria-label="accueil"
                    >
                        <Logo class="logo h-12 md:h-16" />
                    </a>
                    <div
                        class="menu-button is-close w-nav-button"
                        style="-webkit-user-select: text"
                        aria-label="menu"
                        role="button"
                        tabindex="0"
                        aria-controls="w-nav-overlay-0"
                        aria-haspopup="menu"
                        aria-expanded="false"
                    >
                        <div class="menu-button-wrapper">
                            <div class="menu-icon-wrapper">
                                <div
                                    class="menu-horizontal-bar first-bar"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        transform-style: preserve-3d;
                                    "
                                ></div>
                                <div
                                    class="menu-horizontal-bar middle"
                                    style="opacity: 1"
                                ></div>
                                <div
                                    class="menu-horizontal-bar last-bar"
                                    style="
                                        transform: translate3d(0px, 0px, 0px)
                                            scale3d(1, 1, 1) rotateX(0deg)
                                            rotateY(0deg) rotateZ(0deg)
                                            skew(0deg, 0deg);
                                        transform-style: preserve-3d;
                                    "
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-menu-wrap">
                    <Link
                        v-for="(item, index) in mainStore.menuItems"
                        :key="item.label"
                        :href="route(item.route)"
                        prefetch
                        :cache-for="item.cache || '5m'"
                        class="nav-link-item w-inline-block"
                        :class="{
                            'color-primary': route().current(item.route),
                        }"
                    >
                        <div class="nav-link-text-wrapper">
                            <div class="nav-link-text" style="">
                                {{ item.label }}
                            </div>
                            <div class="nav-link-text is-behind" style="">
                                {{ item.label }}
                            </div>
                        </div>
                    </Link>
                    <NavResources />
                    <div class="nav-button-wrapper is-under-dropdown">
                        <Link
                            data-wf--button-button-primary--variant="full-width"
                            :href="route('login')"
                            class="button-primary-wrapper w-variant-b0966095-80c1-8595-61e3-54372fefee2d w-inline-block"
                            ><div
                                class="button-shadow"
                                style="
                                    transform: translate3d(8px, 8px, 0px)
                                        scale3d(1, 1, 1) rotateX(0deg)
                                        rotateY(0deg) rotateZ(0deg)
                                        skew(0deg, 0deg);
                                    transform-style: preserve-3d;
                                "
                            ></div>
                            <div
                                class="button-primary w-variant-b0966095-80c1-8595-61e3-54372fefee2d"
                            >
                                <div class="button-text-wrapper">
                                    <div class="button-text">Connexion</div>
                                    <div class="button-text is-behind">
                                        Connexion
                                    </div>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>
            </nav>
            <HeaderNavRight />
        </div>

        <!-- Nav Overlay -->
        <div class="w-nav-overlay" data-wf-ignore="" id="w-nav-overlay-0"></div>
        <!-- End of NavOverlay -->
    </div>
</template>
