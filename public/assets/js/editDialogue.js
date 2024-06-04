    const editCharacter = document.querySelectorAll('.edit');
    const editCharacterForm = document.querySelectorAll('.character-edit');
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
