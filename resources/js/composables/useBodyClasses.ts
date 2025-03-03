import { onMounted, onUnmounted, watch } from "vue";

export function useBodyClasses(classNames: string) {
    const classes = classNames.split(/\s+/).filter(Boolean); // Séparer et filtrer les classes vides

    const addClasses = () => {
        classes.forEach((className) => document.body.classList.add(className));
    };

    const removeClasses = () => {
        classes.forEach((className) =>
            document.body.classList.remove(className),
        );
    };

    onMounted(addClasses); // Ajoute les classes au montage
    onUnmounted(removeClasses); // Supprime les classes au démontage

    watch(
        () => classNames,
        (newClasses, oldClasses) => {
            if (newClasses !== oldClasses) {
                removeClasses();
                classNames = newClasses;
                addClasses();
            }
        },
    );
}
