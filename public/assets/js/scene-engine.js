//background script

const body = document.querySelector("body");
const background = document.getElementById("scene-background");

document.addEventListener('DOMContentLoaded', () => {
    if (background.src && background.src !== window.location.href) {
        body.style.backgroundImage = "url(" + background.src + ")";
    } else {
        body.style.backgroundImage = "url(/assets/images/backgrounds/black.jpg)";
    }
})

//edit script

//const sceneTitle = document.querySelector('.title');
const editScene = document.querySelector('.edit-scene');
const editSceneForm = document.querySelector('.edit-scene-form');
const cancelScene = document.querySelector('.cancel-scene');

    editScene.addEventListener('click', () => {
        editSceneForm.classList.toggle("visible");
        //sceneTitle.classList.toggle("visible");
    })

    cancelScene.addEventListener('click', (e) => {
        e.preventDefault();
        editSceneForm.classList.toggle("visible");
        //sceneTitle.classList.toggle("visible");
    })