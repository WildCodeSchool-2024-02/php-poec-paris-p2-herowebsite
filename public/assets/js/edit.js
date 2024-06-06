const editCharacter = document.querySelectorAll('.character-edit');
const editCharacterForm = document.querySelectorAll('.character-edit-form');
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
    
const editDialogue = document.querySelectorAll('.dialogue-edit');
const editDialogueForm = document.querySelectorAll('.dialogue-edit-form');
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

const editChoice = document.querySelectorAll('.choice-edit');
const editChoiceForm = document.querySelectorAll('.choice-edit-form');
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
    
const addCharacter = document.querySelector('.add-character');
const addCharacterForm = document.querySelector('.character-add-form');

addCharacter.addEventListener('click', ()=> {
    addCharacterForm.style.display = 'inline-block';
}) 

const addDialogue = document.querySelector('.add-dialogue');
const addDialogueForm = document.querySelector('.dialogue-add-form');

addDialogue.addEventListener('click', ()=> {
    addDialogueForm.style.display = 'inline-block';
} )

const addChoice = document.querySelector('.add-choice');
const addChoiceForm = document.querySelector('.choice-add-form');

addDialogue.addEventListener('click', ()=> {
    addChoiceForm.style.display = 'inline-block';
} )
    