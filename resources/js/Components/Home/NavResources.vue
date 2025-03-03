<script setup>
import { useMainStore } from "@/stores/main";
import SocialLinks from "./SocialLinks.vue";

const mainStore = useMainStore();
</script>
<template>
    <div
        data-hover="false"
        data-delay="0"
        data-w-id="4de1255d-a207-31fe-6e89-8efec43afa2b"
        class="navbar-dropdown w-dropdown"
    >
        <div
            class="dropdown-toggle w-dropdown-toggle"
            id="w-dropdown-toggle-0"
            aria-controls="w-dropdown-list-0"
            aria-haspopup="menu"
            aria-expanded="false"
            role="button"
            tabindex="0"
        >
            <div class="dropdown-text">Ressources</div>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="100%"
                viewBox="0 0 11 6"
                fill="none"
                class="dropdown-arrow-icon"
                style="
                    transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1)
                        rotateX(0deg) rotateY(0deg) rotateZ(0deg)
                        skew(0deg, 0deg);
                    transform-style: preserve-3d;
                "
            >
                <path
                    d="M1.65387 1L5.65387 5L9.65387 1"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                ></path>
            </svg>
        </div>
        <nav
            class="dropdown-list w-dropdown-list"
            style="
                display: none;
                transform: translate3d(0px, 5px, 0px) scale3d(1, 1, 1)
                    rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg);
                transform-style: preserve-3d;
                opacity: 0;
                width: 100%;
                height: 0px;
            "
            id="w-dropdown-list-0"
            aria-labelledby="w-dropdown-toggle-0"
        >
            <div class="dropdown-menu-wrapper">
                <div
                    id="w-node-_4de1255d-a207-31fe-6e89-8efec43afa34-c43afa1c"
                    class="dropdown-menu-column"
                >
                    <a
                        v-for="(item, index) in mainStore.resourceItems"
                        :key="item.label"
                        aria-lavel="nav dropdown menu"
                        :href="item.href"
                        class="nav-link-item paddingx-none w-inline-block"
                        tabindex="0"
                        ><div class="nav-link-text-wrapper">
                            <div class="nav-link-text">
                                {{ item.label }}
                            </div>
                            <div class="nav-link-text is-behind">
                                {{ item.label }}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="nav-dropdown-bottom">
                <p>
                    © Copyright&nbsp;
                    <a
                        :href="$page.props.app.url"
                        target="_blank"
                        class="flowfye-link underline"
                        tabindex="0"
                        >{{ $page.props.app.name }}</a
                    >
                </p>
                <div class="nav-social-wrapper">
                    <SocialLinks />
                </div>
            </div>
        </nav>
    </div>
</template>
