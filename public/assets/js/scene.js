/**
 * @file
 * Ce script gère l'affichage séquentiel des dialogues et des sprites dans une interface utilisateur.
 * Au clic sur le bouton "Continuer", il passe au dialogue et au sprite suivant.
 * Une fois tous les dialogues affichés, il cache le bouton "Continuer" et affiche une div contenant des choix si disponibles,
 * ou remplace le bouton par un lien de retour.
 */

// Attend que le DOM soit complètement chargé avant d'exécuter le code
document.addEventListener("DOMContentLoaded", function () {
    // Récupère le bouton de continuité
    const continueButton = document.getElementById("continue-button");
    // Récupère tous les éléments avec la classe "dialogue"
    const dialogues = document.querySelectorAll(".dialogue");
    // Récupère tous les éléments avec la classe "sprite"
    const sprites = document.querySelectorAll(".sprite");
    // Récupère la div contenant les choix
    const choicesDiv = document.querySelector(".choices");
    // Récupère l'identifiant de l'histoire depuis l'attribut data-story-id de la div des choix
    const storyId = choicesDiv.getAttribute("data-story-id");
    // Initialise l'index du dialogue actuel à 0
    let currentDialogueIndex = 0;

    // Fonction pour afficher ou masquer un élément en fonction de l'index et du paramètre show
    const showElement = (index, show) => {
        dialogues[index].classList.toggle("hidden", !show);
        sprites[index].classList.toggle("hidden", !show);
    };

    // Fonction pour gérer le clic sur le bouton "Continuer"
    const handleContinueClick = () => {
        // Masque l'élément actuel
        showElement(currentDialogueIndex, false);

        // Vérifie si tous les dialogues ont été affichés
        if (currentDialogueIndex >= dialogues.length - 1) {
            // Cache le bouton "Continuer"
            continueButton.style.display = "none";

            // Vérifie s'il y a des choix disponibles
            if (document.querySelectorAll(".choice-link").length > 0) {
                // Affiche la div des choix
                choicesDiv.style.display = "block";
                // Affiche le dernier dialogue (si nécessaire)
                showElement(currentDialogueIndex, true);
            } else {
                // Si aucun choix n'est disponible, remplace le bouton "Continuer" par un lien de retour
                continueButton.outerHTML = `<a href="/scene/show?storyId=${storyId}/credits" class="btn">Retour</a>`;
            }
        } else {
            // Incrémente l'index du dialogue actuel
            currentDialogueIndex++;
            // Affiche le dialogue suivant
            showElement(currentDialogueIndex, true);
        }
    };

    // Ajoute un gestionnaire d'événements pour le clic sur le bouton "Continuer"
    continueButton.addEventListener("click", handleContinueClick);
    // Affiche le premier dialogue et le premier sprite
    showElement(currentDialogueIndex, true);
});
