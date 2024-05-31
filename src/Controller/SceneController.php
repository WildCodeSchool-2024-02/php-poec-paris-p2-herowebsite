<?php

namespace App\Controller;

use App\Model\SceneManager;
use App\Model\DialogueManager;
use App\Model\ChoiceManager;

class SceneController extends AbstractController
{
    /**
     * Show the first scene of a specific story.
     */
    public function show(int $id): string
    {
        if ($id > 0) {
            $sceneManager = new SceneManager();
            $scene = $sceneManager->selectOneById($id);

            if ($scene) {
                $DialogueManager = new DialogueManager();
                $ChoiceManager = new ChoiceManager();

                $dialogues = $DialogueManager->getdialoguesBySceneId($id);
                $choices = $ChoiceManager->getChoicesBySceneId($id);

                return $this->twig->render('Scene/show.html.twig', [
                    'scene' => $scene,
                    'dialogues' => $dialogues,
                    'choices' => $choices
                ]);
            } else {
                return $this->twig->render('Error/404.html.twig', ['message' => 'Scene not found for this story.']);
            }
        } else {
            return $this->twig->render('Error/400.html.twig', ['message' => 'No story ID provided.']);
        }
    }
}
/**
 * Handle the next scene based on the user's choice.

    public function next(): string
    {
        if (isset($_POST['story_id']) && isset($_POST['scene_id'])) {
            $story_id = (int)$_POST['story_id'];
            $scene_id = (int)$_POST['scene_id'];

            if ($story_id && $scene_id) {
                $sceneManager = new SceneManager();
                $nextScene  = $sceneManager->findScene($story_id, $scene_id);
                if ($nextScene) {
                    header('Location: /scene/show?id=' . $nextScene['id']);
                    exit();
                } else {
                    return $this->twig->render('Error/404.html.twig', ['message' => 'Next scene not found.']);
                }
            } else {
                return $this->twig->render('Error/400.html.twig', ['message' => 'Invalid story or scene ID.']);
            }
        } else {
            return $this->twig->render('Error/400.html.twig', ['message' => 'Story ID and Scene ID are required.']);
        }
    }
}
 */
