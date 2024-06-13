//edit script

const editChoice = document.querySelectorAll('.edit-choice');
const editChoiceForm = document.querySelectorAll('.edit-choice-form');
const cancelChoice = document.querySelectorAll('.cancel-choice');

for (let i = 0; i < editChoice.length; i++) {
    editChoice[i].addEventListener('click', () => {
        editChoiceForm[i].classList.toggle("visible");
    })

    cancelChoice[i].addEventListener('click', (e) => {
        e.preventDefault();
        editChoiceForm[i].classList.toggle("visible");
    })
}

//add script

const addChoice = document.querySelector('.add-choice');
const addChoiceForm = document.querySelector('.add-choice-form');
const finalScene = document.getElementById("final-scene");
const choicesList = document.querySelector(".choices-list");

addChoice.addEventListener("click", () => {
    const currentChoices = choicesList.querySelectorAll("li");
    if (currentChoices.length < 3) {
        addChoiceForm.classList.toggle("visible");
    } else {
        alert("Vous ne pouvez pas ajouter plus de 3 choix.");
    }
});

for (let i = 0; i < cancelChoice.length; i++) {
    cancelChoice[i].addEventListener('click', (e) => {
        e.preventDefault();
        editChoiceForm[i].style.display = "none";
    });
}

//toggle and use finalScene
const finalSceneWrapper = document.getElementById("final-scene-wrapper");
const currentChoices = choicesList.querySelectorAll("li");
if (currentChoices.length === 0) {
    finalSceneWrapper.classList.remove("hidden");
} else {
    finalSceneWrapper.classList.add("hidden");
}

finalScene.addEventListener('click', () => {
    addChoice.classList.toggle('hidden-choices');
    if (addChoiceForm.classList.contains("visible"))
        {
            addChoiceForm.classList.toggle('visible');
        }
})

//toggle modal

const choiceButton = document.querySelector('#choice-button');
const choiceView = document.querySelector('#choice-view');

choiceButton.addEventListener('click', () => {

    characterView.style.display = 'none';
    dialogueView.style.display = 'none';
    choiceView.style.display = 'block';
});