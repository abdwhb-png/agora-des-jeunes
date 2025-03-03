<template>
    <div class="menu" data-menu="true">
        <div
            class="menu-item"
            data-menu-item-offset="0, 10px"
            data-menu-item-placement="bottom-end"
            data-menu-item-placement-rtl="bottom-start"
            data-menu-item-toggle="dropdown"
            data-menu-item-trigger="click|lg:click"
        >
            <button class="menu-toggle btn btn-sm btn-icon btn-light btn-clear">
                <i class="ki-filled ki-dots-vertical"> </i>
            </button>
            <div
                class="menu-dropdown menu-default w-full max-w-[175px]"
                data-menu-dismiss="true"
                style=""
            >
                <div v-if="props.view" class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-filled ki-search-list"> </i>
                        </span>
                        <span class="menu-title"> Voir </span>
                    </a>
                </div>
                <div v-if="props.export" class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-filled ki-file-up"> </i>
                        </span>
                        <span class="menu-title"> Exporter </span>
                    </a>
                </div>
                <div class="menu-separator"></div>
                <div v-if="props.edit" class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-filled ki-pencil text-primary"> </i>
                        </span>
                        <span class="menu-title"> Modifier </span>
                    </a>
                </div>
                <div v-if="props.edit" class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-filled ki-copy"> </i>
                        </span>
                        <span class="menu-title"> Copier </span>
                    </a>
                </div>
                <div class="menu-separator"></div>
                <div v-if="props.remove" class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="menu-icon">
                            <i class="ki-filled ki-trash text-danger"> </i>
                        </span>
                        <span class="menu-title"> Supprimer </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const props = defineProps({
    item: { type: Object, required: true },
    view: { type: Function, default: null },
    export: { type: Function, default: null },
    edit: { type: Function, default: null },
    remove: { type: Function, default: null },
});

const emits = defineEmits(["view", "export", "edit", "remove"]);

const view = () => {
    if (props.view) {
        props.view(props.item);
    }
    emits("view", item);
};

const exportFn = () => {
    if (props.export) {
        props.export(props.item);
    }
    emits("export", item);
};

const edit = () => {
    if (props.edit) {
        props.edit(props.item);
    }
    emits("edit", item);
};

const remove = () => {
    if (props.remove) {
        props.remove(props.item);
    }
    emits("remove", item);
};
</script>
