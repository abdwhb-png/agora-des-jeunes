import { ref } from 'vue';

export type ToastType = 'success' | 'error' | 'warning' | 'info';

interface Toast {
    id: number;
    type: ToastType;
    message: string;
    duration?: number;
}

export function useToast() {
    const toasts = ref<Toast[]>([]);
    let nextId = 1;

    const addToast = (type: ToastType, message: string, duration = 3000) => {
        const id = nextId++;
        const toast: Toast = { id, type, message, duration };
        toasts.value.push(toast);

        if (duration > 0) {
            setTimeout(() => {
                removeToast(id);
            }, duration);
        }
    };

    const removeToast = (id: number) => {
        const index = toasts.value.findIndex((t) => t.id === id);
        if (index !== -1) {
            toasts.value.splice(index, 1);
        }
    };

    const success = (message: string, duration?: number) => {
        addToast('success', message, duration);
    };

    const error = (message: string, duration?: number) => {
        addToast('error', message, duration);
    };

    const warning = (message: string, duration?: number) => {
        addToast('warning', message, duration);
    };

    const info = (message: string, duration?: number) => {
        addToast('info', message, duration);
    };

    return {
        toasts,
        success,
        error,
        warning,
        info,
        removeToast,
    };
} 