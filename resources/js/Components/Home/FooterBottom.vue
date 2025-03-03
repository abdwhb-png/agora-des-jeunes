<template>
    <div class="footer-bottom">
        <div class="padding-global">
            <div class="container">
                <div class="section-inner footer-bottom-inner items-center">
                    <div class="footer-copyright-text text-center order-2">
                        © {{ new Date().getFullYear() }} Tous droits réservés.
                        <a
                            :href="$page.props.app.url"
                            target="_blank"
                            class="flowfye-link"
                            >{{ $page.props.app.name }}</a
                        >. &nbsp;Sité créé par
                        <a
                            :href="$page.props.dev.site_url"
                            target="_blank"
                            class="webflow-link underline"
                            >{{ $page.props.dev.name }}</a
                        >.
                    </div>
                    <div
                        v-if="
                            $page.props.jetstream
                                .hasTermsAndPrivacyPolicyFeature
                        "
                        class="flex text-center gap-2"
                    >
                        <Link
                            :href="route('terms.show')"
                            target="_blank"
                            class="privacy-policy-link underline"
                            >Conditions d'utilisations
                        </Link>
                        <Link
                            :href="route('policy.show')"
                            target="_blank"
                            class="privacy-policy-link underline"
                            >Politique de confidentialité
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
