<?php

namespace App\Controller;

use App\Model\StoryManager;
use App\Model\SceneManager;
use App\Model\DialogueManager;
use App\Model\ChoiceManager;

// use App\Model\UserSaveManager; à venir

class SceneController extends AbstractController
{
    public function show(int $storyId, int $sceneId)
    {
        // Utiliser SceneManager pour obtenir les informations sur la scène
        $sceneManager = new SceneManager();
        $scene = $sceneManager->findScene($storyId, $sceneId);
        // Log the result of findScene
        if ($scene) {
            error_log("Scene found: " . print_r($scene, true));
        } else {
            error_log("No scene found for storyId: $storyId, sceneId: $sceneId");
        }

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

    public function showFirstScene(int $storyId)
    {
        //      function custom_log($message)
        //        {
        //         echo $message . PHP_EOL; // PHP_EOL represents the end of line character
        //     }

        $sceneManager = new SceneManager();
        $firstSceneId = $sceneManager->findFirstSceneIdOfStory($storyId);
        $firstSceneId = intval($firstSceneId);

        // Vérifiez si l'identifiant de la première scène a été trouvé
        if (!$firstSceneId) {
            // Gérer l'erreur (par exemple, renvoyer une réponse 404)
            header("HTTP/1.0 404 Not Found");
            echo 'coucou';
            exit();
        }

        // Afficher la première scène de l'histoire
        return $this->show($storyId, $firstSceneId);
    }
}
