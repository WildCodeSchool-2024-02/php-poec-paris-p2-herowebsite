//edit script

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

//add script

const addDialogue = document.querySelector('.add-dialogue');
const addDialogueForm = document.querySelector('.add-dialogue-form');
const cancelAddDialogue = document.querySelectorAll('.cancel-add-dialogue');


addDialogue.addEventListener('click', () => {
    addDialogueForm.classList.toggle("visible");
})
for (let i = 0; i < cancelAddDialogue.length; i++) {
    cancelAddDialogue[i].addEventListener("click", (e) => {
        e.preventDefault();
        addDialogueForm.classList.toggle("visible");
    })
}

//toggle modal

const dialogueButton = document.querySelector('#dialogue-button');
const dialogueView = document.querySelector('#dialogue-view');

dialogueButton.addEventListener('click', () => {

    characterView.style.display = 'none';
    dialogueView.style.display = 'block';
    choiceView.style.display = 'none';
});