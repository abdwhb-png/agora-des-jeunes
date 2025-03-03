<style lang="scss">
@import "@css/dash-hero.css";
</style>

<script setup>
import { getIcon } from "@/utils/helpers";
import { usePage } from "@inertiajs/vue3";
import { cvBuilderUrl } from "@/config/appInit";

const page = usePage();
const routePrefix = page.props.routePrefix;

const items = [
    {
        title: "Entreprendre",
        icon: getIcon("entreprendre"),
        route: routePrefix + "entreprendre",
    },
    {
        title: "Se Former",
        icon: getIcon("formation"),
        route: routePrefix + "formation",
    },
    {
        title: "Emploi",
        icon: getIcon("emploi"),
        route: routePrefix + "emploi",
    },
    {
        title: "Création CV",
        icon: getIcon("cv"),
        url: cvBuilderUrl,
    },
];

const itemContent = (item) => {
    return `<span
                class="RV8RoaI_SlEMC5CEQ3ms _9OKVeTXzfSwD_NYO6_G kqgYncRJQ7spwKfig6It q6R7ifHNsy60SzijPw4M HzSN_B__bXx8FUbQhXu_ neyUwteEn7DOg9pBSJJE _WclR59Ji8jwfmjPtOei _Qk4_E9_iLqcHsRZZ4ge PWreZZgitgAm_Nv4Noh9 pxHuWvF853ck68OLN6ef yjGyQxv8jnYk9_MGMqLN yFAsiu26MUcycUf9RwrL _BIVSYBXQUqEf_ltPrSk _t2wg7hRcyKsNN8CSSeU xotVay0PVtR3gElm6ql5"
            >
                <i class="text-3xl ${item.icon}"></i>
            </span>
            <span
                class="rD4HtsUG_hahmbh2Kj09 VwrSTsh__so52zqMJvws LYMps1kO2vF8HBymW3az g3OYBOqwXUEW4dRGogkH _5zvlMLkN1qETxEl3IhT a0Ed69aMSu0vgf4oysz0"
            >
                ${item.title}
            </span>`;
};
</script>

<template>
    <section
        class="jCHKuJ3G7rklx_LiAfbf RFT3unXiLA2kbmlb8f6_ cmyDPxbqOqbqHiEyGnG8 zlFmyfujKXCLCPyPEOIS z_I3ZSqHC3yeRFg5K0tP"
    >
        <div
            class="_EGl649n_Sjwb5RGLAt9 POA0xdG25nlhxqWJyl1U pcWvkQQ8p_VQZFs_K2QA _6AI6SY1lyVfKpv37xl0 Nf72SRfIMOn_5YU7Y5Gl"
        >
            <div
                class="QYPW4nl6nHaIbrtaXf4h _v8hjA9ct_v6OhSQD7fC RV8RoaI_SlEMC5CEQ3ms _Y8m3EApcgnyDOY6pRW3 veFXkDzfJN473U3ycrV8 Vng8vsaWLN3Lh7gErp_m XG_JHZii6VUFSUkjd4Kc _F_1gdhzusC6tSOWHtx_ wP9HMsqy6b96l2HBRbgb BcwKNryVHiY5BN934sI_ Xjxpb8u_H96dZt4r1eF6"
            >
                <h1
                    class="text-sky-950 _9OKVeTXzfSwD_NYO6_G _Bu4HL5sPDOGN_IKUsOc P2kov_od1FPjxxII24T5 jGqC6Vyq4r7i62RWVQU_ marR_sCaF_d1KewmkXGX text-primary-900 a0Ed69aMSu0vgf4oysz0 _FSCxmo0RizP2YBRYajk"
                >
                    {{ $page.props.config.seo.slogan }}
                </h1>
                <p
                    class="font-light text-sky-800 SGCI_v4dZasZ65DtKHsW XdjN1uxS_rsa3F90ox40 text-primary-800 eCx_6PNzncAD5yo7Qcic BygxL63OH6g8tW90EiE8 F_2Dre6FGlusaaY9LAdu EsIS9JBcwCwjZrc4Kr4F"
                >
                    Don't Miss Out - Limited Stock at Rock-Bottom Prices!
                </p>
                <Button label="Commencer" severity="warn" raised class="mt-4" />
            </div>
        </div>
        <div class="RXPX15H5pmHbfVS0_NCt veFXkDzfJN473U3ycrV8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-4">
                <div
                    v-for="(item, index) in items"
                    :key="item.title"
                    class="_F_1gdhzusC6tSOWHtx_"
                >
                    <a
                        v-if="item.url"
                        :href="item.url"
                        target="_blank"
                        v-html="itemContent(item)"
                    >
                    </a>
                    <Link
                        v-else
                        :href="route(item.route)"
                        prefetch
                        v-html="itemContent(item)"
                    >
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
