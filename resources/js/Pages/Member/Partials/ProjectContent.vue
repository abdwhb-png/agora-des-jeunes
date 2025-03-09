<script setup>
defineProps({
    project: { type: Object, required: true },
    section: String,
});
</script>

<template>
    <template v-if="section == 'metadata'">
        <div
            v-if="project.duration"
            class="grid grid-cols-1 content-between gap-1.5 border border-dashed border-gray-300 shrink-0 rounded-md px-2.5 py-2 min-w-24 max-w-auto"
        >
            <span class="text-gray-700 text-xs"> Durée </span>
            <span class="text-gray-900 text-2sm leading-none font-medium">
                {{ project.duration }}
            </span>
        </div>
        <div
            v-if="project.location"
            class="grid grid-cols-1 content-between gap-1.5 border border-dashed border-gray-300 shrink-0 rounded-md px-2.5 py-2 min-w-24 max-w-auto"
        >
            <span class="text-gray-700 text-xs"> Lieu </span>
            <span class="text-gray-900 text-2sm leading-none font-medium">
                {{ project.location }}
            </span>
        </div>
        <div
            v-if="project.team_count"
            class="grid grid-cols-1 content-between gap-1.5 border border-dashed border-gray-300 shrink-0 rounded-md px-2.5 py-2 min-w-24 max-w-auto"
        >
            <span class="text-gray-700 text-xs"> Nombre de personnes </span>
            <span class="text-gray-900 text-2sm leading-none font-medium">
                {{ project.team_count }}
            </span>
        </div>
    </template>
    <div v-else-if="section == 'dropdown'" class="menu" data-menu="true">
        <div
            class="menu-item menu-item-dropdown"
            data-menu-item-offset="0, 10px"
            data-menu-item-placement="bottom-end"
            data-menu-item-toggle="dropdown"
            data-menu-item-trigger="click|lg:click"
        >
            <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                <i class="ki-filled ki-dots-vertical"> </i>
            </button>
            <div
                class="menu-dropdown menu-default w-full max-w-[200px]"
                data-menu-dismiss="true"
            >
                <div class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-filled ki-pencil"> </i>
                        </span>
                        <span class="menu-title"> Modifier </span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-filled ki-file-down"> </i>
                        </span>
                        <span class="menu-title"> Télécharger </span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-filled ki-share"> </i>
                        </span>
                        <span class="menu-title"> Partager </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
