const body = document.querySelector("body");
const background = document.getElementById("background");

document.addEventListener('DOMContentLoaded', () => {
    if (background.src && background.src !== window.location.href) {
        body.style.backgroundImage = "url(" + background.src + ")";
        background.classList.toggle("pas-empty");
    }
})

const sceneTitle = document.querySelector('.title');
const editScene = document.querySelector('.edit-scene');
const editSceneForm = document.querySelector('.edit-scene-form');
const cancelScene = document.querySelector('.cancel-scene');

    editScene.addEventListener('click', () => {
        editSceneForm.classList.toggle("visible");
        sceneTitle.classList.toggle("visible");
    })

    cancelScene.addEventListener('click', (e) => {
        e.preventDefault();
        editSceneForm.classList.toggle("visible");
        sceneTitle.classList.toggle("visible");
    })

const editCharacter = document.querySelectorAll('.edit-character');
const editCharacterForm = document.querySelectorAll('.edit-character-form');
const cancelCharacter = document.querySelectorAll('.cancel-character');

for (let i = 0; i < editCharacter.length; i++) {
    editCharacter[i].addEventListener('click', () => {
        editCharacterForm[i].classList.toggle("visible");
    })

    cancelCharacter[i].addEventListener("click", (e) => {
        e.preventDefault();
        editCharacterForm[i].classList.toggle("visible");
    })
}

const editDialogue = document.querySelectorAll('.edit-dialogue');
const editDialogueForm = document.querySelectorAll('.edit-dialogue-form');
const cancelDialogue = document.querySelectorAll('.cancel-dialogue');

for (let i = 0; i < editDialogue.length; i++) {
    editDialogue[i].addEventListener('click', () => {
        editDialogueForm[i].classList.toggle("visible");
    })

    cancelDialogue[i].addEventListener('click', (e) => {
        e.preventDefault();
        editDialogueForm[i].classList.toggle("visible");
    })
}

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

const addCharacter = document.querySelector('.add-character');
const addCharacterForm = document.querySelector('.add-character-form');

addCharacter.addEventListener('click', () => {
    addCharacterForm.classList.toggle("visible");
})
for (let i = 0; i < cancelCharacter.length; i++) {
    cancelCharacter[i].addEventListener('click', (e) => {
        e.preventDefault();
        addCharacterForm.classList.toggle("visible");
    })
}

const addDialogue = document.querySelector('.add-dialogue');
const addDialogueForm = document.querySelector('.add-dialogue-form');


addDialogue.addEventListener('click', () => {
    addDialogueForm.classList.toggle("visible");
})
for (let i = 0; i < cancelDialogue.length; i++) {
    cancelDialogue[i].addEventListener("click", (e) => {
        e.preventDefault();
        addDialogueForm.classList.toggle("visible");
    })
}

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

finalScene.addEventListener('click', () => {
    addChoice.classList.toggle('hidden-choices');
    addChoiceForm.style.display = 'none';
})

const characterButton = document.querySelector('#character-button');
const characterView = document.querySelector('#character-view');

const dialogueButton = document.querySelector('#dialogue-button');
const dialogueView = document.querySelector('#dialogue-view');

const choiceButton = document.querySelector('#choice-button');
const choiceView = document.querySelector('#choice-view');

characterButton.addEventListener('click', () => {

    characterView.style.display = 'block';
    dialogueView.style.display = 'none';
    choiceView.style.display = 'none';
});

dialogueButton.addEventListener('click', () => {

    characterView.style.display = 'none';
    dialogueView.style.display = 'block';
    choiceView.style.display = 'none';
});

choiceButton.addEventListener('click', () => {

    characterView.style.display = 'none';
    dialogueView.style.display = 'none';
    choiceView.style.display = 'block';
});
