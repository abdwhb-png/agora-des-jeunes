<template>
    <Head title="Mot de passe modifié" />
    <AuthLayout>
        <div class="card max-w-[440px] w-full">
            <div class="card-body p-10">
                <div class="flex justify-center mb-5">
                    <img
                        alt="image"
                        class="dark:hidden max-h-[180px]"
                        src="/static/metronic/tailwind/dist/assets/media/illustrations/32.svg"
                    />
                    <img
                        alt="image"
                        class="light:hidden max-h-[180px]"
                        src="/static/metronic/tailwind/dist/assets/media/illustrations/32-dark.svg"
                    />
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-4">
                    Mot de passe modifié
                </h3>
                <div class="text-2sm text-center text-gray-700 mb-7.5">
                    Ton mot de passe a été mis à jour avec succès.
                    <br />
                    La sécurité de ton compte est notre priorité.
                </div>
                <div class="flex justify-center">
                    <Link class="btn btn-primary" href="/"> Continuer </Link>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>
