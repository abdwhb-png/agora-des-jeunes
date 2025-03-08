<template>
    <span
        class="RV8RoaI_SlEMC5CEQ3ms _9OKVeTXzfSwD_NYO6_G kqgYncRJQ7spwKfig6It q6R7ifHNsy60SzijPw4M HzSN_B__bXx8FUbQhXu_ neyUwteEn7DOg9pBSJJE _WclR59Ji8jwfmjPtOei _Qk4_E9_iLqcHsRZZ4ge PWreZZgitgAm_Nv4Noh9 pxHuWvF853ck68OLN6ef yjGyQxv8jnYk9_MGMqLN yFAsiu26MUcycUf9RwrL _BIVSYBXQUqEf_ltPrSk _t2wg7hRcyKsNN8CSSeU xotVay0PVtR3gElm6ql5"
    >
        <component
            v-if="item.iconComp"
            :is="item.iconComp"
            :size="30"
        ></component>
        <i v-else-if="item.icon" class="text-3xl" :class="item.icon"></i>
    </span>
    <span
        class="capitalize rD4HtsUG_hahmbh2Kj09 VwrSTsh__so52zqMJvws LYMps1kO2vF8HBymW3az g3OYBOqwXUEW4dRGogkH _5zvlMLkN1qETxEl3IhT a0Ed69aMSu0vgf4oysz0"
    >
        {{ item.title }}
    </span>
</template>

<script setup>
defineProps({
    item: {
        type: Object,
        required: true,
    },
});
</script>
