<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    two_step_verification: Boolean(props.user.account.two_step_verification),
    allow_tracking: Boolean(props.user.account.allow_tracking),
});

const submit = () => {
    form.put(route("user.account.update", props.user.id), {
        preserveScroll: true,
        onSuccess: () => {},
    });
};
</script>

<template>
    <div class="flex flex-col gap-5 lg:gap-7.5" id="account_settings">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Paramètres du compte</h3>
            </div>
            <div
                class="card-group flex items-center justify-between py-4 gap-2.5"
            >
                <div class="flex items-center gap-3.5">
                    <div class="relative size-[50px] shrink-0">
                        <svg
                            class="w-full h-full stroke-gray-300 fill-gray-100"
                            fill="none"
                            height="48"
                            viewBox="0 0 44 48"
                            width="44"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506
			18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937
			39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z"
                                fill=""
                            ></path>
                            <path
                                d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506
			18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937
			39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z"
                                stroke=""
                            ></path>
                        </svg>
                        <div
                            class="absolute inset-0 flex items-center justify-center"
                        >
                            <i
                                class="ki-filled ki-shield-tick text-2xl text-gray-500"
                            ></i>
                        </div>
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <span
                            class="flex items-center gap-1.5 leading-none font-medium text-sm text-gray-900"
                        >
                            Activer la vérification à deux étapes
                        </span>
                        <span class="text-2sm text-gray-700">
                            Ajoutes une couche supplémentaire de sécurité avec
                            la verification à deux étapes.
                        </span>
                    </div>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="switch switch-sm">
                        <input
                            @change="submit"
                            v-model="form.two_step_verification"
                            name="two_step_verification"
                            type="checkbox"
                        />
                    </div>
                </div>
            </div>
            <div
                class="card-group flex items-center justify-between py-4 gap-2.5"
            >
                <div class="flex items-center gap-3.5">
                    <div class="relative size-[50px] shrink-0">
                        <svg
                            class="w-full h-full stroke-gray-300 fill-gray-100"
                            fill="none"
                            height="48"
                            viewBox="0 0 44 48"
                            width="44"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M16 2.4641C19.7128 0.320509 24.2872 0.320508 28 2.4641L37.6506 8.0359C41.3634 10.1795 43.6506 14.141 43.6506
			18.4282V29.5718C43.6506 33.859 41.3634 37.8205 37.6506 39.9641L28 45.5359C24.2872 47.6795 19.7128 47.6795 16 45.5359L6.34937
			39.9641C2.63655 37.8205 0.349365 33.859 0.349365 29.5718V18.4282C0.349365 14.141 2.63655 10.1795 6.34937 8.0359L16 2.4641Z"
                                fill=""
                            ></path>
                            <path
                                d="M16.25 2.89711C19.8081 0.842838 24.1919 0.842837 27.75 2.89711L37.4006 8.46891C40.9587 10.5232 43.1506 14.3196 43.1506
			18.4282V29.5718C43.1506 33.6804 40.9587 37.4768 37.4006 39.5311L27.75 45.1029C24.1919 47.1572 19.8081 47.1572 16.25 45.1029L6.59937
			39.5311C3.04125 37.4768 0.849365 33.6803 0.849365 29.5718V18.4282C0.849365 14.3196 3.04125 10.5232 6.59937 8.46891L16.25 2.89711Z"
                                stroke=""
                            ></path>
                        </svg>
                        <div
                            class="absolute inset-0 flex items-center justify-center"
                        >
                            <i
                                class="ki-filled ki-parcel-tracking text-2xl text-gray-500"
                            ></i>
                        </div>
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <span
                            class="flex items-center gap-1.5 leading-none font-medium text-sm text-gray-900"
                        >
                            Autoriser le tracking
                        </span>
                        <span class="text-2sm text-gray-700">
                            Tu autorises le tracking des cookies et des données
                            de localisation
                        </span>
                    </div>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="switch switch-sm">
                        <input
                            @change="submit"
                            :checked="form.allow_tracking ? true : false"
                            v-model="form.allow_tracking"
                            name="allow_tracking"
                            type="checkbox"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
