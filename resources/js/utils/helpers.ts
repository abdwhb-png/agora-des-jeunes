// utils/helpers.ts

export const dialogBreakpoints: Record<string, string> = {
    "1199px": "75vw",
    "575px": "90vw",
};

export function getHeight(element: HTMLElement): number {
    return element ? element.getBoundingClientRect().height : 0;
}

export function sleep(ms: number = 1000): Promise<void> {
    return new Promise((resolve) => setTimeout(resolve, ms));
}

export function getIcon(key: string): string {
    const icons = {
        role: "ki-filled ki-share",
        permission: "ki-filled ki-key-square",
        profile: "ki-filled ki-badge",
        profil: "ki-filled ki-user-tick",
        account: "ki-filled ki-user-square",
        profile_pic: "ki-filled ki-face-id",
        entreprendre: "ki-filled ki-abstract-27",
        formation: "ki-filled ki-book-open",
        emploi: "ki-filled ki-abstract-26",
        cv: "ki-filled ki-mouse-square",
    };

    return icons[key] ?? "ki-filled ki-abstract-27";
}

export function neighbourColor(index: number): string {
    const colors = [
        "#10b981", // emerald-500
        "#0ea5e9", // sky-500
        "#f97316", // orange-500
        "#64748b", // slate-500
        "#78716c", // stone-500
    ];
    return colors[index] ?? colors[4]; // Retourne `stone-500` par défaut
}

export function generateColor(index: number, opactity: number = 1): string {
    const r = (index * 90) % 256; // Adjust the multiplier for different shades
    const g = (index * 60) % 256;
    const b = (index * 60) % 256;
    return `rgb(${r},${g},${b},${opactity})`;
}

export function formatJsonToPrint(json, showKeys = false) {
    return Object.entries(json)
        .map(([key, value]) => {
            // Si la valeur est un objet ou un tableau, la convertir en chaîne JSON
            if (typeof value === "object" && value !== null) {
                value = JSON.stringify(value, null, 2);
            }
            return `<p><b>${showKeys ? key + ":" : "●"}</b> ${value}</p>`;
        })
        .join("\n"); // Retour à la ligne entre les paires clé/valeur
}

export function copyToClipboard(text: string) {
    navigator.clipboard.writeText(text);
    alert("Texte copié dans le presse-papier");
}

export const throttle = (func: (...args: any[]) => void, limit: number) => {
    let lastFunc: any;
    let lastRan: number;
    return function (this: any, ...args: any[]) {
        if (!lastRan) {
            func.apply(this, args);
            lastRan = Date.now();
        } else {
            clearTimeout(lastFunc);
            lastFunc = setTimeout(
                () => {
                    if (Date.now() - lastRan >= limit) {
                        func.apply(this, args);
                        lastRan = Date.now();
                    }
                },
                limit - (Date.now() - lastRan),
            );
        }
    };
};
