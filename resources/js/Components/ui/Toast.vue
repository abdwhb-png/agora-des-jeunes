<template>
    <div class="toast-container">
        <TransitionGroup name="toast">
            <div
                v-for="toast in toasts"
                :key="toast.id"
                class="toast"
                :class="`toast-${toast.type}`"
                role="alert"
                aria-live="assertive"
                aria-atomic="true"
            >
                <div class="toast-header">
                    <strong class="me-auto">{{ getTitle(toast.type) }}</strong>
                    <button
                        type="button"
                        class="btn-close"
                        @click="removeToast(toast.id)"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="toast-body">
                    {{ toast.message }}
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<script setup lang="ts">
import { useToast, type ToastType } from "@/composables/ui/myToast";

const { toasts, removeToast } = useToast();

function getTitle(type: ToastType): string {
    switch (type) {
        case "success":
            return "Succès";
        case "error":
            return "Erreur";
        case "warning":
            return "Attention";
        case "info":
            return "Information";
        default:
            return "";
    }
}
</script>

<style scoped>
.toast-container {
    position: fixed;
    top: 1rem;
    right: 1rem;
    z-index: 1050;
}

.toast {
    min-width: 250px;
    margin-bottom: 0.5rem;
    padding: 0.5rem;
    background-color: #fff;
    border-radius: 0.25rem;
    box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
}

.toast-header {
    display: flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    background-color: rgba(0, 0, 0, 0.03);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.toast-body {
    padding: 0.5rem;
}

.toast-success {
    border-left: 4px solid #198754;
}

.toast-error {
    border-left: 4px solid #dc3545;
}

.toast-warning {
    border-left: 4px solid #ffc107;
}

.toast-info {
    border-left: 4px solid #0dcaf0;
}

.btn-close {
    padding: 0.25rem;
    background-color: transparent;
    border: 0;
    cursor: pointer;
}

.btn-close::before {
    content: "×";
    font-size: 1.5rem;
    line-height: 1;
}

/* Transition animations */
.toast-enter-active,
.toast-leave-active {
    transition: all 0.3s ease;
}

.toast-enter-from {
    opacity: 0;
    transform: translateX(30px);
}

.toast-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>
