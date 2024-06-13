//edit script

const editCharacter = document.querySelectorAll('.edit-character');
const editCharacterForm = document.querySelectorAll('.edit-character-form');
const card = document.querySelectorAll('.card');

console.log(editCharacter);
for (let i = 0; i < editCharacter.length; i++) {
    editCharacter[i].addEventListener('click', () => {
        editCharacterForm[i].classList.toggle("edit-visible");
        card[i].classList.toggle("big-card");
    })
}

//add script

const addCharacter = document.querySelector('.add-character');
const addCharacterForm = document.querySelector('.add-character-form');
const cancelAddCharacter = document.querySelector('.cancel-add-character');

    addCharacter.addEventListener('click', () => {
    addCharacter.classList.toggle('add-hidden');
    addCharacterForm.classList.toggle("visible");
    cancelAddCharacter.classList.toggle("edit-visible");
    })

    cancelAddCharacter.addEventListener('click', (e) => {
        e.preventDefault();
        addCharacter.classList.toggle('add-hidden');
        addCharacterForm.classList.toggle("visible");
        cancelAddCharacter.classList.toggle("edit-visible");
    })
