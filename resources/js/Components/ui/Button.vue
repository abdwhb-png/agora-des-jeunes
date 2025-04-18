<template>
    <button :type="type" :disabled="disabled || loading" class="btn" :class="[
        variant && `btn-${variant}`,
        size && `btn-${size}`,
        { 'btn-loading': loading }
    ]" @click="$emit('click', $event)">
        <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
        <slot></slot>
    </button>
</template>

<script setup lang="ts">
defineProps<{
    type?: 'button' | 'submit' | 'reset';
    variant?: 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'light' | 'dark' | 'link';
    size?: 'sm' | 'lg';
    disabled?: boolean;
    loading?: boolean;
}>();

defineEmits<{
    (e: 'click', event: MouseEvent): void;
}>();
</script>

<style scoped>
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    user-select: none;
    border: 1px solid transparent;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.btn:disabled {
    opacity: 0.65;
    pointer-events: none;
}

.btn-primary {
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn-primary:hover {
    color: #fff;
    background-color: #0b5ed7;
    border-color: #0a58ca;
}

.btn-secondary {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    color: #fff;
    background-color: #5c636a;
    border-color: #565e64;
}

.btn-success {
    color: #fff;
    background-color: #198754;
    border-color: #198754;
}

.btn-success:hover {
    color: #fff;
    background-color: #157347;
    border-color: #146c43;
}

.btn-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    color: #fff;
    background-color: #bb2d3b;
    border-color: #b02a37;
}

.btn-warning {
    color: #000;
    background-color: #ffc107;
    border-color: #ffc107;
}

.btn-warning:hover {
    color: #000;
    background-color: #ffca33;
    border-color: #ffc720;
}

.btn-info {
    color: #000;
    background-color: #0dcaf0;
    border-color: #0dcaf0;
}

.btn-info:hover {
    color: #000;
    background-color: #31d2f2;
    border-color: #25cff2;
}

.btn-light {
    color: #000;
    background-color: #f8f9fa;
    border-color: #f8f9fa;
}

.btn-light:hover {
    color: #000;
    background-color: #f9fafb;
    border-color: #f9fafb;
}

.btn-dark {
    color: #fff;
    background-color: #212529;
    border-color: #212529;
}

.btn-dark:hover {
    color: #fff;
    background-color: #1c1f23;
    border-color: #1a1d20;
}

.btn-link {
    color: #0d6efd;
    text-decoration: underline;
}

.btn-link:hover {
    color: #0a58ca;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-radius: 0.2rem;
}

.btn-lg {
    padding: 0.5rem 1rem;
    font-size: 1.25rem;
    border-radius: 0.3rem;
}

.spinner-border {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    vertical-align: text-bottom;
    border: 0.2em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-border .75s linear infinite;
}

@keyframes spinner-border {
    to {
        transform: rotate(360deg);
    }
}
</style>