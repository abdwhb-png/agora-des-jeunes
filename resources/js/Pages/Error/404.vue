<template>
    <ErrorLayout title="404 Error">
        <div class="flex flex-col items-center">
            <div class="mb-10">
                <img
                    alt="image"
                    class="dark:hidden max-h-[160px]"
                    src="/static/media/illustrations/19.svg"
                />
                <img
                    alt="image"
                    class="light:hidden max-h-[160px]"
                    src="/static/media/illustrations/19-dark.svg"
                />
            </div>
            <span class="badge badge-primary badge-outline mb-3">
                Erreur 404
            </span>
            <h3 class="text-2.5xl font-semibold text-gray-900 text-center mb-2">
                Page non trouvée
            </h3>
            <div class="text-md text-center text-gray-700 mb-10">
                La page demandée est absente.
                <br />
                Veuillez vérifier l'URL ou
                <a
                    class="text-primary font-medium hover:text-primary-active"
                    href="/"
                >
                    Retourner sur la page d'accueil
                </a>
                .
            </div>
            <div class="relative">
                <form action="/">
                    <input
                        class="input ps-8 max-w-64"
                        placeholder="Rechercher une page"
                        type="text"
                        value=""
                    />
                    <button
                        class="btn btn-clear btn-icon text-gray-500 btn-sm absolute start-0 top-2/4 -translate-y-2/4 ms-1"
                    >
                        <i class="ki-filled ki-magnifier"> </i>
                    </button>
                </form>
            </div>
        </div>
    </ErrorLayout>
</template>
