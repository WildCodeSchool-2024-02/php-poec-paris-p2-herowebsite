document.addEventListener("DOMContentLoaded", () => {
    // Récupère l'élément du bouton "continue" par son identifiant.
    const continueButton = document.getElementById("continue-button");
    // Récupère tous les éléments avec la classe "dialogue".
    const dialogues = document.querySelectorAll(".dialogue");
    // Récupère tous les éléments avec la classe "sprite".
    const sprites = document.querySelectorAll(".sprite");
    // Récupère l'élément avec la classe "choices".
    const choicesDiv = document.querySelector(".choices");
    // Récupère l'ID de l'histoire à partir de l'attribut data-story-id de l'élément choicesDiv.
    const storyId = choicesDiv.dataset.storyId;
    // Initialise l'index du dialogue actuel à 0.
    let currentDialogueIndex = 0;

    // Fonction pour afficher un élément (dialogue et sprite) à un index donné.
    const showElement = (index) => {
        dialogues[index].classList.remove("hidden");
        sprites[index].classList.remove("hidden");
    };

    // Fonction pour masquer un élément (dialogue et sprite) à un index donné.
    const hideElement = (index) => {
        dialogues[index].classList.add("hidden");
        sprites[index].classList.add("hidden");
    };

    // Fonction pour afficher le dialogue suivant.
    const showNextDialogue = () => {
        // Vérifie si l'index actuel est inférieur à la longueur de la liste des dialogues moins un.
        if (currentDialogueIndex < dialogues.length - 1) {
            // Masque l'élément actuel.
            hideElement(currentDialogueIndex);
            // Incrémente l'index du dialogue actuel.
            currentDialogueIndex++;
            // Affiche le nouvel élément.
            showElement(currentDialogueIndex);
        } else {
            // Masque le bouton "continue" lorsque tous les dialogues sont affichés.
            continueButton.style.display = "none";
            // Vérifie si des choix sont disponibles.
            if (choicesDiv.querySelectorAll(".choice-link").length > 0) {
                // Affiche les choix si des liens de choix existent.
                choicesDiv.style.display = "block";
            } else {
                // Remplace le bouton "continue" par un lien de retour vers les crédits si aucun choix n'est disponible.
                continueButton.outerHTML = `<a href="/scene/show?storyId=${storyId}/credits" class="btn">Retour</a>`;
            }
        }
    };

    // Ajoute un écouteur d'événements au bouton "continue" pour afficher le dialogue suivant au clic.
    continueButton.addEventListener("click", showNextDialogue);
    // Affiche le premier dialogue et sprite au chargement de la page.
    showElement(currentDialogueIndex);
});
