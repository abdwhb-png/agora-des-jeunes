<template>
    <div
        class="notice d-flex rounded border border-dashed mb-9 p-6"
        :class="`bg-light-${severity} border-${severity}`"
    >
        <i
            class="ki-filled text-3xl me-4"
            :class="`ki-${getIcon()} text-${severity}`"
        ></i>
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack flex-grow-1">
            <!--begin::Content-->
            <div class="fw-semobold">
                <h4
                    v-if="title"
                    class="text-gray-800 fw-bold"
                    v-html="title"
                ></h4>

                <div v-if="$slots.content" class="fs-6 text-gray-600">
                    <slot name="content" />
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
</template>

<script setup>
const props = defineProps({
    title: { type: String, default: "" },
    severity: {
        type: String,
        default: "primary",
    },
});

const getIcon = () => {
    switch (props.severity) {
        case "primary":
            return "information";
        case "danger":
            return "exclamation-2";
        case "success":
            return "check-2";
        case "secondary":
            return "check-2";
        case "warning":
            return "warning-2";
    }
};
</script>
