const editCharacter = document.querySelectorAll('.edit_character');
const editCharacterForm = document.querySelectorAll('.edit_character_form');
const cancelCharacter = document.querySelectorAll('.cancel-character');

for (let i=0; i<editCharacter.length; i++)
    {
        editCharacter[i].addEventListener('click', () => {
            editCharacterForm[i].style.display = 'inline-block';
        })

        cancelCharacter[i].addEventListener('click', (e) =>{
            e.preventDefault();
            editCharacterForm[i].style.display = 'none';
        })
    }

const editDialogue = document.querySelectorAll('.edit_dialogue');
const editDialogueForm = document.querySelectorAll('.edit_dialogue_form');
const cancelDialogue = document.querySelectorAll('.cancel_dialogue');

for (let i=0; i<editDialogue.length; i++)
    {
        editDialogue[i].addEventListener('click', () => {
            editDialogueForm[i].style.display = 'inline-block';
        })

        cancelDialogue[i].addEventListener('click', (e) =>{
            e.preventDefault();
            editDialogueForm[i].style.display = 'none';
        })
    }

const editChoice = document.querySelectorAll('.edit_choice');
const editChoiceForm = document.querySelectorAll('.edit_choice_form');
const cancelChoice = document.querySelectorAll('.cancel_choice');

for (let i=0; i<editChoice.length; i++)
    {
        editChoice[i].addEventListener('click', () => {
            editChoiceForm[i].style.display = 'inline-block';
        })

        cancelChoice[i].addEventListener('click', (e) =>{
             e.preventDefault();
             editChoiceForm[i].style.display = 'none';
        })
    }

const addCharacter = document.querySelector('.add_character');
const addCharacterForm = document.querySelector('.add_character_form');

addCharacter.addEventListener('click', ()=> {
    addCharacterForm.style.display = 'inline-block';
})

const addDialogue = document.querySelector('.add_dialogue');
const addDialogueForm = document.querySelector('.add_dialogue_form');

addDialogue.addEventListener('click', ()=> {
    addDialogueForm.style.display = 'inline-block';
} )

const addChoice = document.querySelector('.add_choice');
const addChoiceForm = document.querySelector('.add_choice_form');

addChoice.addEventListener('click', ()=> {
    addChoiceForm.style.display = 'inline-block';
} )
