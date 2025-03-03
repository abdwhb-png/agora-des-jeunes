export function useCustomConfirm(confirm: any) {
    const deleteConfirm = (
        accept: Function,
        reject: Function | null = null,
    ) => {
        confirm.require({
            message: "Voulez vous supprimer cet élément ?",
            header: "Zone de danger",
            icon: "pi pi-info-circle",
            rejectProps: {
                label: "Annuler",
                severity: "secondary",
                outlined: true,
            },
            acceptProps: {
                label: "Supprimer",
                severity: "danger",
            },
            accept: () => {
                accept();
            },
            reject: () => {
                if (reject) reject();
            },
        });
    };

    const actionConfirm = (
        accept: Function,
        reject: Function | null = null,
    ) => {
        confirm.require({
            message: "Etes-vous sur de vouloir effectuer cette action ?",
            header: "Veuillez confirmer",
            icon: "pi pi-question-circle",
            rejectProps: {
                label: "Annuler",
                severity: "secondary",
                outlined: true,
            },
            acceptProps: {
                label: "Confirmer",
                severity: "primary",
            },
            accept: () => {
                accept();
            },
            reject: () => {
                if (reject) reject();
            },
        });
    };

    return { deleteConfirm, actionConfirm };
}
