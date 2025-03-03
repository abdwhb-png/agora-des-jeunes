<script setup>
import { usePage } from "@inertiajs/vue3";
import { useMainStore } from "@/stores/main";
import Logo from "@/Components/Logo.vue";
import FooterBottom from "./FooterBottom.vue";
import SocialLinks from "./SocialLinks.vue";
import { Button } from "@/Components/ui/button";

const config = usePage().props.config;
const mainStore = useMainStore();
</script>

<template>
    <footer class="footer">
        <div class="padding-global section-padding-regular is-bottom-zero">
            <div class="container">
                <div class="section-inner section-footer">
                    <div class="footer-top">
                        <div class="footer-info">
                            <div class="margin-bottom margin-16px">
                                <a
                                    href="/"
                                    aria-label="Brand Logo"
                                    class="brand w-inline-block"
                                >
                                    <Logo class="h-16" />
                                </a>
                            </div>
                            <div class="margin-bottom margin-30px">
                                <div>{{ $page.props.config.seo.slogan }}</div>
                            </div>
                            <div class="margin-bottom margin-40px">
                                <div class="social-icon-wrapper">
                                    <SocialLinks
                                        linkClass="social-icon-item w-inline-block"
                                    />
                                </div>
                            </div>
                            <div class="button-container">
                                <Button as-child variant="outline">
                                    <Link :href="route('login')">
                                        <i class="pi pi-user"></i>
                                        Mon Compte
                                    </Link>
                                </Button>
                            </div>
                        </div>
                        <div class="footer-links">
                            <div class="footer-link-column">
                                <div class="footer-link-column-title">
                                    Pages
                                </div>
                                <div class="footer-link-wrapper">
                                    <Link
                                        v-for="link in mainStore.menuItems"
                                        :key="link.label"
                                        :href="route(link.route)"
                                        prefetch
                                        :cache-for="link.cache || '5m'"
                                        class="footer-link-item w-inline-block"
                                    >
                                        <div class="button-box">
                                            <div class="button-box-moves">
                                                <div class="button-link-text">
                                                    {{ link.label }}
                                                </div>
                                                <div
                                                    class="button-link-text absolute"
                                                >
                                                    {{ link.label }}
                                                </div>
                                            </div>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                            <div class="footer-link-column">
                                <div class="footer-link-column-title">
                                    Ressources
                                </div>
                                <div class="footer-link-wrapper">
                                    <Link
                                        v-for="link in mainStore.resourceItems"
                                        :key="link.label"
                                        :href="link.href"
                                        class="footer-link-item w-inline-block"
                                    >
                                        <div class="button-box">
                                            <div class="button-box-moves">
                                                <div class="button-link-text">
                                                    {{ link.label }}
                                                </div>
                                                <div
                                                    class="button-link-text absolute"
                                                >
                                                    {{ link.label }}
                                                </div>
                                            </div>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                            <div
                                id="w-node-_18d869dc-ff3b-62d3-efd4-747ae73c24d0-e73c2460"
                                class="footer-link-column _3"
                            >
                                <div class="footer-link-column-title">
                                    Contact
                                </div>
                                <div class="footer-link-wrapper">
                                    <a
                                        :href="`tel:${config.site_phone}`"
                                        class="footer-link-item w-inline-block"
                                        ><div class="button-box">
                                            <div class="button-box-moves">
                                                <div class="button-link-text">
                                                    {{ config.site_phone }}
                                                </div>
                                                <div
                                                    class="button-link-text absolute"
                                                >
                                                    {{ config.site_phone }}
                                                </div>
                                            </div>
                                        </div></a
                                    ><a
                                        :href="`mailto:${config.site_email}`"
                                        class="footer-link-item w-inline-block"
                                        ><div class="button-box">
                                            <div class="button-box-moves">
                                                <div class="button-link-text">
                                                    {{ config.site_email }}
                                                </div>
                                                <div
                                                    class="button-link-text absolute"
                                                >
                                                    {{ config.site_email }}
                                                </div>
                                            </div>
                                        </div></a
                                    >
                                    <div class="footer-item">
                                        <div>
                                            {{ config.site_address }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <FooterBottom />
        <!-- End of Footer Bottom -->
    </footer>
</template>
