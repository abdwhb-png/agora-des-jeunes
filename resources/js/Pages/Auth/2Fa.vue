<template>
    <Head title="2FA" />
    <AuthLayout>
        <div class="card max-w-[380px] w-full" id="2fa_form">
            <form
                action="#"
                class="card-body flex flex-col gap-5 p-10"
                method="post"
            >
                <img
                    alt="image"
                    class="dark:hidden h-20 mb-2"
                    src="/static/metronic/tailwind/dist/assets/media/illustrations/34.svg"
                />
                <img
                    alt="image"
                    class="light:hidden h-20 mb-2"
                    src="/static/metronic/tailwind/dist/assets/media/illustrations/34-dark.svg"
                />
                <div class="text-center mb-2">
                    <h3 class="text-lg font-medium text-gray-900 mb-5">
                        Verify your phone
                    </h3>
                    <div class="flex flex-col">
                        <span class="text-2sm text-gray-700 mb-1.5">
                            Enter the verification code we sent to
                        </span>
                        <a class="text-sm font-medium text-gray-900" href="#">
                            ****** 7859
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap justify-center gap-2.5">
                    <input
                        class="input focus:border-primary-clarity focus:ring focus:ring-primary-clarity size-10 shrink-0 px-0 text-center"
                        maxlength="1"
                        name="code_0"
                        placeholder=""
                        type="text"
                        value=""
                    />
                    <input
                        class="input focus:border-primary-clarity focus:ring focus:ring-primary-clarity size-10 shrink-0 px-0 text-center"
                        maxlength="1"
                        name="code_1"
                        placeholder=""
                        type="text"
                        value=""
                    />
                    <input
                        class="input focus:border-primary-clarity focus:ring focus:ring-primary-clarity size-10 shrink-0 px-0 text-center"
                        maxlength="1"
                        name="code_2"
                        placeholder=""
                        type="text"
                        value=""
                    />
                    <input
                        class="input focus:border-primary-clarity focus:ring focus:ring-primary-clarity size-10 shrink-0 px-0 text-center"
                        maxlength="1"
                        name="code_3"
                        placeholder=""
                        type="text"
                        value=""
                    />
                    <input
                        class="input focus:border-primary-clarity focus:ring focus:ring-primary-clarity size-10 shrink-0 px-0 text-center"
                        maxlength="1"
                        name="code_4"
                        placeholder=""
                        type="text"
                        value=""
                    />
                    <input
                        class="input focus:border-primary-clarity focus:ring focus:ring-primary-clarity size-10 shrink-0 px-0 text-center"
                        maxlength="1"
                        name="code_5"
                        placeholder=""
                        type="text"
                        value=""
                    />
                </div>
                <div class="flex items-center justify-center mb-2">
                    <span class="text-xs text-gray-700 me-1.5">
                        Didn’t receive a code? (37s)
                    </span>
                    <a
                        class="text-xs link"
                        href="/metronic/tailwind/demo4/authentication/branded/sign-in/"
                    >
                        Resend
                    </a>
                </div>
                <button class="btn btn-primary flex justify-center grow">
                    Continue
                </button>
            </form>
        </div>
    </AuthLayout>
</template>
