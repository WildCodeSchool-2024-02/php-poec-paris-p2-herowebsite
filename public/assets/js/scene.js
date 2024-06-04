document.addEventListener("DOMContentLoaded", function () {
    let continueButton = document.getElementById("continue-button");
    let dialogues = document.querySelectorAll(".dialogue");
    let sprites = document.querySelectorAll(".sprite");
    let choiceLinks = document.querySelectorAll(".choice-link");
    let choicesDiv = document.querySelector(".choices");

    let currentDialogueIndex = 0;

    continueButton.addEventListener("click", () => {
        // Cacher le dialogue et l'image actuels
        dialogues[currentDialogueIndex].classList.add("hidden");
        sprites[currentDialogueIndex].classList.add("hidden");

        // Passer au dialogue et à l'image suivants
        currentDialogueIndex++;

        // Si nous avons atteint la fin des dialogues
        if (currentDialogueIndex >= dialogues.length) {
            // Cacher le bouton "Continuer"
            continueButton.style.display = "none";

            // Si il y a des liens de choix disponibles, afficher la div des choix
            if (choiceLinks.length > 0) {
                choicesDiv.style.display = "block";
            } else {
                // Sinon, changer le bouton "Continuer" en un lien de retour à la page d'accueil
                continueButton.outerHTML =
                    '<a href="/story" id="home-link" class="btn">Retour';
            }
        } else {
            // Afficher le nouveau dialogue et la nouvelle image
            dialogues[currentDialogueIndex].classList.remove("hidden");
            sprites[currentDialogueIndex].classList.remove("hidden");
        }
    });
});
