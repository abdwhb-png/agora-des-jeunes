<template>
    <ErrorLayout>
        <div class="flex flex-col items-center">
            <div class="mb-16">
                <img
                    alt="image"
                    class="dark:hidden max-h-[160px]"
                    src="/static/media/illustrations/20.svg"
                />
                <img
                    alt="image"
                    class="light:hidden max-h-[160px]"
                    src="/static/media/illustrations/20-dark.svg"
                />
            </div>
            <span class="badge badge-primary badge-outline mb-3">
                Erreur 500
            </span>
            <h3 class="text-2.5xl font-semibold text-gray-900 text-center mb-2">
                Erreur Interne Serveur
            </h3>
            <div class="text-md text-center text-gray-700 mb-10">
                Une erreur interne du serveur s'est produite. Veuillez réessayer
                ou
                <a
                    class="text-primary font-medium hover:text-primary-active"
                    href="#"
                >
                    Nous Contacter
                </a>
                pour assistance.
            </div>
            <a class="btn btn-primary flex justify-center" href="/">
                Accueil
            </a>
        </div>
    </ErrorLayout>
</template>
