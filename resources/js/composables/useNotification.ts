import axios from "axios";

export function useNotification(toast: any) {
    const notify = (type: "success" | "error", message: string) => {
        toast.add({
            severity: type,
            summary: type.charAt(0).toUpperCase() + type.slice(1),
            detail: message,
            life: 3000,
        });
    };

    const read = async (id: number) => {
        try {
            const { data } = await axios.post(route("notifications.read", id));
            if (data.success) notify("success", data.message);
            if (data.fail) notify("error", data.fail);
        } catch (error) {
            notify(
                "error",
                "Une erreur est survenue lors de la lecture de la notification.",
            );
        }
    };

    const readAll = async () => {
        try {
            await axios.post(route("notifications.readAll"));
            notify(
                "success",
                "Toutes les notifications ont été marquées comme lues.",
            );
        } catch (error) {
            notify(
                "error",
                "Impossible de marquer toutes les notifications comme lues.",
            );
        }
    };

    const archive = async () => {
        try {
            await axios.post(route("notifications.archiveAll"));
            notify("success", "Les notifications ont été archivées.");
        } catch (error) {
            notify("error", "Erreur lors de l’archivage des notifications.");
        }
    };

    return {
        read,
        readAll,
        archive,
    };
}
