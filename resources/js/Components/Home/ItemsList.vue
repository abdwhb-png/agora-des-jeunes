<script setup lang="ts">
interface Props {
    list: Array<any> | Object; // ou un type plus spécifique si vous le connaissez
}
defineProps<Props>();
</script>
<template>
    <ul
        data-w-id="6b4d99a9-d471-1bf0-0aec-d5b8570cd49e"
        style="
            transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg)
                rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg);
            transform-style: preserve-3d;
            opacity: 1;
        "
        role="list"
        class="how-work-item-list mt-3"
    >
        <li
            v-for="(item, index) in list"
            :key="index"
            class="how-work-list-item"
        >
            <div class="how-work-list-icon">
                <v-lazy-image
                    src="/cdn.prod.website-files.com/67590e9b756ef477159ae9e4/677525dafc4c34b2e4cfa73b_List%20Icon.svg"
                    alt="icon de liste"
                    class="image-auto"
                />
            </div>
            <p v-html="item"></p>
        </li>
    </ul>
</template>
