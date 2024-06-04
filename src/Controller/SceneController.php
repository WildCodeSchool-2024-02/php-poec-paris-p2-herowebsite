<?php

namespace App\Controller;

use App\Model\StoryManager;
use App\Model\SceneManager;
use App\Model\DialogueManager;
use App\Model\ChoiceManager;

// use App\Model\UserSaveManager; à venir

class SceneController extends AbstractController
{
    // Affiche une scène par son ID et celui de l'histoire
    public function show(int $storyId, int $sceneId): string
    {
        // Utiliser SceneManager pour obtenir les informations sur la scène
        $sceneManager = new SceneManager();
        $scene = $sceneManager->findScene($storyId, $sceneId);

        // Vérifier si la scène existe, sinon renvoyer une erreur 404
        if (!$scene) {
            header("HTTP/1.0 404 Not Found");
            echo '404 - Page not found';
            exit();
        }

        // Utiliser DialogueManager pour obtenir les dialogues de la scène
        $dialogueManager = new DialogueManager();
        $dialogues = $dialogueManager->getDialoguesBySceneId($sceneId);

        // Utiliser ChoiceManager pour obtenir les choix de la scène
        $choiceManager = new ChoiceManager();
        $choices = $choiceManager->getChoicesBySceneId($sceneId);

        // Rendre la vue avec les données récupérées
        return $this->twig->render('Scene/show.html.twig', [
            'scene' => $scene,
            'dialogues' => $dialogues,
            'choices' => $choices
        ]);
    }

    // Affiche la première scène d'une histoire en trouvant le scène ID correspondant
    /**
     * Solution alternative, intégrer cette gestion dans le cas où sceneID est null dans la méthode show ⏫
     * Solution 2 rendre le paramètre storyID optionnel et dans ce cas changer le datamapper pour
     * faire une condition qui changerait la requête en ajoutant ORDER BY id ASC LIMIT 1
     */

    public function showFirstScene(int $storyId): string
    {
        $sceneManager = new SceneManager();
        $firstSceneId = $sceneManager->findFirstSceneIdOfStory($storyId);
        $firstSceneId = intval($firstSceneId);

        // Vérifiez si l'identifiant de la première scène a été trouvé
        if (!$firstSceneId) {
            header("HTTP/1.0 404 Not Found");
            echo '404 - Page not found';
            exit();
        }

        // Afficher la première scène de l'histoire
        return $this->show($storyId, $firstSceneId);
    }
}
