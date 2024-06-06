const editCharacter = document.querySelectorAll('.character-edit');
const editCharacterForm = document.querySelectorAll('.character-edit-form');
const cancel = document.querySelectorAll('.cancel');

for (let i=0; i<editCharacter.length; i++)
    {
        editCharacter[i].addEventListener('click', () => {
            editCharacterForm[i].style.display = 'inline-block';
        })

        cancel[i].addEventListener('click', (e) =>{
            e.preventDefault();
            editCharacterForm[i].style.display = 'none';
        })
    }
    
const editDialogue = document.querySelectorAll('.dialogue-edit');
const editDialogueForm = document.querySelectorAll('.dialogue-edit-form');
const dCancel = document.querySelectorAll('.d_cancel');

for (let i=0; i<editDialogue.length; i++)
    {
        editDialogue[i].addEventListener('click', () => {
            editDialogueForm[i].style.display = 'inline-block';
        })

        dCancel[i].addEventListener('click', (e) =>{
            e.preventDefault();
            editDialogueForm[i].style.display = 'none';
        })
    }  

const editChoice = document.querySelectorAll('.choice-edit');
const editChoiceForm = document.querySelectorAll('.choice-edit-form');
const cCancel = document.querySelectorAll('.c_cancel');

for (let i=0; i<editChoice.length; i++)
    {
        editChoice[i].addEventListener('click', () => {
            editChoiceForm[i].style.display = 'inline-block';
        })

        cCancel[i].addEventListener('click', (e) =>{
             e.preventDefault();
             editChoiceForm[i].style.display = 'none';
        })
    }                    
    