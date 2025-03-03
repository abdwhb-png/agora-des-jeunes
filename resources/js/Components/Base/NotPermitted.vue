<template>
    <div class="flex justify-center items-center min-h-[500px]">
        <Card>
            <template #content>
                <div class="text-center">
                    <h3 class="text-2xl mb-3">
                        Vous n'avez pas les autorisations requises pour voir
                        cette page !
                    </h3>
                    <div class="flex flex-wrap justify-center gap-3">
                        <Link class="btn btn-primary btn-lg" href="/">
                            <i class="ki-filled ki-home"></i>
                            Tableau de bord
                        </Link>
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup></script>
