//edit script

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

//add script

const addCharacter = document.querySelector('.add-character');
const addCharacterForm = document.querySelector('.add-character-form');
const cancelAddCharacter = document.querySelector('.cancel-add-character');

    addCharacter.addEventListener('click', () => {
    addCharacterForm.classList.toggle("visible");
    })

    cancelAddCharacter.addEventListener('click', (e) => {
        e.preventDefault();
        addCharacterForm.classList.toggle("visible");
    })

//toggle modal

const characterButton = document.querySelector('#character-button');
const characterView = document.querySelector('#character-view');

characterButton.addEventListener('click', () => {

    characterView.style.display = 'block';
    dialogueView.style.display = 'none';
    choiceView.style.display = 'none';
});