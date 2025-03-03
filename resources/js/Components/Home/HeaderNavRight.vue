<script setup>
import { usePage } from "@inertiajs/vue3";
import Search from "./Search.vue";

const isAuth = usePage().props.auth.user ? true : false;
</script>

<template>
    <div class="nav-right">
        <div
            class="w-commerce-commercecartwrapper"
            data-node-type="commerce-cart-wrapper"
        >
            <Search />
        </div>
        <div
            class="w-commerce-commercecartwrapper"
            data-node-type="commerce-cart-wrapper"
        >
            <Link
                class="w-commerce-commercecartopenlink cart-button w-inline-block"
                role="button"
                v-tooltip.bottom="
                    $page.props.auth.user ? 'Mon Compte' : 'Connexion'
                "
                aria-haspopup="dialog"
                aria-label="Open empty cart"
                data-node-type="commerce-cart-open-link"
                :href="route('login')"
            >
                <i class="pi pi-user"></i>
            </Link>
        </div>
        <div
            v-if="$page.props.auth.user"
            class="w-commerce-commercecartwrapper"
            data-node-type="commerce-cart-wrapper"
        >
            <Button asChild v-slot="slotProps" severity="contrast" outlined>
                <Link
                    method="post"
                    as="button"
                    :href="route('logout')"
                    :class="slotProps.class"
                >
                    <i class="pi pi-sign-out"></i>
                    Déconnexion
                </Link>
            </Button>
        </div>
        <div
            v-if="!$page.props.auth.user && route().has('register')"
            class="nav-button-wrapper"
        >
            <Link
                data-wf--button-button-primary--variant="base"
                :href="route('register')"
                class="button-primary-wrapper w-inline-block"
                ><div
                    class="button-shadow"
                    style="
                        transform: translate3d(8px, 8px, 0px) scale3d(1, 1, 1)
                            rotateX(0deg) rotateY(0deg) rotateZ(0deg)
                            skew(0deg, 0deg);
                        transform-style: preserve-3d;
                    "
                ></div>
                <div class="button-primary">
                    <div class="button-text-wrapper">
                        <div class="button-text">Inscription</div>
                        <div class="button-text is-behind">Inscription</div>
                    </div>
                </div>
            </Link>
        </div>
        <div
            class="menu-button w-nav-button"
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
                                scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                rotateZ(0deg) skew(0deg, 0deg);
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
                                scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg)
                                rotateZ(0deg) skew(0deg, 0deg);
                            transform-style: preserve-3d;
                        "
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>
