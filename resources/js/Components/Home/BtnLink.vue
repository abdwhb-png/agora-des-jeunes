<style scoped>
.btn-medium {
    padding: 5px;
}
</style>

<template>
    <a v-if="type == '2'" :class="{
        'bg-white': variant == 'secondary',
        'bg-primary': variant == 'base',
    }" class="rounded-lg shadow-md px-4 py-2 flex items-center gap-2 hover:shadow-lg transition-shadow">
        <span>
            <slot name="icon" />
        </span>
        <span>{{ text }}</span>
    </a>
    <a v-else v-bind="attrs" class="button-primary-wrapper w-inline-block">
        <div class="button-shadow" style="
                transform: translate3d(8px, 8px, 0px) scale3d(1, 1, 1)
                    rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg);
                transform-style: preserve-3d;
            "></div>
        <div class="button-primary" :class="{
            'w-variant-df11cfe8-fb95-3c5a-9007-0ea80cca3abb': variant == 'secondary',
        }
            ">
            <div class="button-content-wrapper">
                <div class="button-icon-wrapper">
                    <span class="button-icon" ref="btnIcon">
                        <slot name="icon" />
                    </span>
                </div>
                <div class="button-text-wrapper">
                    <div class="button-text txt">{{ text }}</div>
                    <div class="button-text is-behind">
                        {{ behindText || text }}
                    </div>
                </div>
            </div>
        </div>
    </a>
</template>

<script setup>
import { onMounted, ref } from "vue";

const props = defineProps({
    variant: {
        type: String,
        default: "base",
    },
    text: {
        type: String,
        required: true,
    },
    behindText: String,
    type: {
        type: [Number, String],
        default: "1",
    },
});

const btnIcon = ref();
const attrs = ref(null);
const attrKey = ref("data-wf--button-button-primary--variant");

onMounted(() => {
    if (btnIcon.value) {
        // check if child
        if (!btnIcon.value.children.length) {
            // delete btnIcon first parent
            btnIcon.value.parentElement.remove();
        } else {
            attrKey.value = "data-wf--button-primary-with-icon--variant";
        }
    }

    attrs.value = {
        [attrKey.value]: props.variant,
    };
});
</script>
