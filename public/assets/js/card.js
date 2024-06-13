document.addEventListener("DOMContentLoaded", function() {

    const scenes = document.querySelectorAll(".clickable");

    scenes.forEach(function(scene) {

        scene.addEventListener("click", function() {
            let url = scene.getAttribute("data-url");
            window.location.href = url;

        });
    });
});
