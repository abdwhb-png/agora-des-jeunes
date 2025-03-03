<template>
    <div class="grid lg:grid-cols-2 gap-5 lg:gap-7.5">
        <div class="card">
            <div class="card-body px-10 py-7.5 lg:pr-12.5">
                <div
                    class="flex flex-wrap md:flex-nowrap items-center gap-6 md:gap-10"
                >
                    <div class="flex flex-col items-start gap-3">
                        <h2 class="text-1.5xl font-medium text-gray-900">
                            Questions ?
                        </h2>
                        <p class="text-sm text-gray-800 leading-5.5 mb-2.5">
                            Vous avez une questions, vous avez besoin de
                            conseils ? Visitez notre foire aux questions.
                        </p>
                    </div>
                    <img
                        alt="image"
                        class="dark:hidden max-h-[150px]"
                        src="/static/media/illustrations/2.svg"
                    />
                    <img
                        alt="image"
                        class="light:hidden max-h-[150px]"
                        src="/static/media/illustrations/2-dark.svg"
                    />
                </div>
            </div>
            <div class="card-footer justify-center">
                <a class="btn btn-link" href="#"> Foire Aux Questions </a>
            </div>
        </div>
        <div class="card">
            <div class="card-body px-10 py-7.5 lg:pr-12.5">
                <div
                    class="flex flex-wrap md:flex-nowrap items-center gap-6 md:gap-10"
                >
                    <div class="flex flex-col items-start gap-3">
                        <h2 class="text-1.5xl font-medium text-gray-900">
                            Support de contact
                        </h2>
                        <p class="text-sm text-gray-800 leading-5.5 mb-2.5">
                            Besoin d'assistance? Contactez notre equipe de
                            support pour une aide prompte et personnalisee
                        </p>
                    </div>
                    <img
                        alt="image"
                        class="dark:hidden max-h-[150px]"
                        src="/static/media/illustrations/4.svg"
                    />
                    <img
                        alt="image"
                        class="light:hidden max-h-[150px]"
                        src="/static/media/illustrations/4-dark.svg"
                    />
                </div>
            </div>
            <div class="card-footer justify-center">
                <a class="btn btn-link" href="#"> Contacter le Support </a>
            </div>
        </div>
    </div>
</template>
