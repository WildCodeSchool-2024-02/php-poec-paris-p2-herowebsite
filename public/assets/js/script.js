document.addEventListener("DOMContentLoaded", function () {
    // Récupérer tous les dialogues
    let dialogues = document.querySelectorAll(".dialogue-box");
    let currentIndex = 0;

    // Cacher tous les dialogues sauf le premier
    for (let i = 1; i < dialogues.length; i++) {
        dialogues[i].style.display = "none";
    }

    // Gestionnaire d'événements pour le bouton "Continuer"
    document
        .querySelector("#continue-button")
        .addEventListener("click", function () {
            // Masquer le dialogue actuel
            if (currentIndex < dialogues.length - 1) {
                dialogues[currentIndex].style.display = "none";
            }
            currentIndex++;

            // Afficher le prochain dialogue
            if (currentIndex < dialogues.length) {
                dialogues[currentIndex].style.display = "block";
            } else {
                // S'il n'y a plus de dialogues, afficher les boutons de choix
                document.querySelector(".choices").style.display = "block";
                // Masquer le bouton "Continuer"
                document.querySelector("#continue-button").style.display =
                    "none";
            }
        });
});
