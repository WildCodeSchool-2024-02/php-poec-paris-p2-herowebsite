document.addEventListener("DOMContentLoaded", function () {
    const dialogues = document.querySelectorAll(".dialogue-box");
    const continueButton = document.getElementById("continue-button");
    let currentDialogueIndex = 0;

    continueButton.addEventListener("click", function () {
        if (currentDialogueIndex < dialogues.length - 1) {
            dialogues[currentDialogueIndex].style.display = "none";
            currentDialogueIndex++;
            dialogues[currentDialogueIndex].style.display = "flex";
        } else {
            continueButton.style.display = "none";
            const choices =
                dialogues[currentDialogueIndex].querySelector(".choices");
            if (choices) {
                choices.style.display = "flex";
            }
        }
    });
});
