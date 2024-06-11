const editScene = document.querySelectorAll('.edit-scene');
const editSceneForm = document.querySelectorAll('.edit-scene-form');
const cancelScene = document.querySelectorAll('.cancel-scene');

for (let i = 0; i < editScene.length; i++) {
    editScene[i].addEventListener('click', () => {
        editSceneForm[i].style.display = 'inline-block';
    })

    cancelScene[i].addEventListener('click', (e) => {
        e.preventDefault();
        editSceneForm[i].style.display = 'none';
    })
}

const editCharacter = document.querySelectorAll('.edit-character');
const editCharacterForm = document.querySelectorAll('.edit-character-form');
const cancelCharacter = document.querySelectorAll('.cancel-character');

for (let i = 0; i < editCharacter.length; i++) {
    editCharacter[i].addEventListener('click', () => {
        editCharacterForm[i].style.display = 'inline-block';
    })

    cancelCharacter[i].addEventListener('click', (e) => {
        e.preventDefault();
        editCharacterForm[i].style.display = 'none';
    })
}

const editDialogue = document.querySelectorAll('.edit-dialogue');
const editDialogueForm = document.querySelectorAll('.edit-dialogue-form');
const cancelDialogue = document.querySelectorAll('.cancel-dialogue');

for (let i = 0; i < editDialogue.length; i++) {
    editDialogue[i].addEventListener('click', () => {
        editDialogueForm[i].style.display = 'inline-block';
    })

    cancelDialogue[i].addEventListener('click', (e) => {
        e.preventDefault();
        editDialogueForm[i].style.display = 'none';
    })
}

const editChoice = document.querySelectorAll('.edit-choice');
const editChoiceForm = document.querySelectorAll('.edit-choice-form');
const cancelChoice = document.querySelectorAll('.cancel-choice');

for (let i = 0; i < editChoice.length; i++) {
    editChoice[i].addEventListener('click', () => {
        editChoiceForm[i].style.display = 'inline-block';
    })

    cancelChoice[i].addEventListener('click', (e) => {
        e.preventDefault();
        editChoiceForm[i].style.display = 'none';
    })
}

const addCharacter = document.querySelector('.add-character');
const addCharacterForm = document.querySelector('.add-character-form');

addCharacter.addEventListener('click', () => {
    addCharacterForm.style.display = 'inline-block';
})
for (let i = 0; i < cancelCharacter.length; i++) {
    cancelCharacter[i].addEventListener('click', (e) => {
        e.preventDefault();
        addCharacterForm.style.display = 'none';
    })
}

const addDialogue = document.querySelector('.add-dialogue');
const addDialogueForm = document.querySelector('.add-dialogue-form');


addDialogue.addEventListener('click', () => {
    addDialogueForm.style.display = 'inline-block';
})
for (let i = 0; i < cancelDialogue.length; i++) {
    cancelDialogue[i].addEventListener('click', (e) => {
        e.preventDefault();
        addDialogueForm.style.display = 'none';
    })
}

const addChoice = document.querySelector('.add-choice');
const addChoiceForm = document.querySelector('.add-choice-form');
const finalScene = document.getElementById("final-scene");

addChoice.addEventListener('click', () => {
    addChoiceForm.style.display = 'inline-block';
})
for (let i = 0; i < cancelChoice.length; i++) {
    cancelChoice[i].addEventListener('click', (e) => {
        e.preventDefault();
        addChoiceForm.style.display = 'none';
    })
}
finalScene.addEventListener('click', () => {
    addChoice.classList.toggle('hidden-choices');
    addChoiceForm.style.display = 'none';
})
