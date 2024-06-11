<?php

namespace App\Controller;

use App\Model\SceneManager;
use App\Model\DialogueManager;
use App\Model\ChoiceManager;

class SceneController extends AbstractController
{
    private $sceneManager;
    private $dialogueManager;

    private $choiceManager;

    public const EXTENSIONS_ALLOWED = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    public const MAX_UPLOAD_SIZE = 5000000;

    public const MAX_SCENE_TITLE_LENGTH = 30;

    public function __construct()
    {
        parent::__construct();
        $this->sceneManager = new SceneManager();
        $this->dialogueManager = new DialogueManager();
        $this->choiceManager = new ChoiceManager();
    }


    public function show(int $sceneId): string
    {
        $scene = $this->sceneManager->selectOneById($sceneId);

        if (!$scene) {
            header("HTTP/1.0 404 Not Found");
            echo '404 - Page not found';
            exit();
        }

        $dialogues = $this->dialogueManager->selectAll($sceneId);

        $choices = $this->choiceManager->selectAll($sceneId);

        return $this->twig->render('Scene/show.html.twig', [
            'scene' => $scene,
            'dialogues' => $dialogues,
            'choices' => $choices
        ]);
    }

    public function showFirstScene(int $storyId): string
    {
        $sceneId = $this->sceneManager->selectFirstByStory($storyId);

        if (!$sceneId) {
            header("HTTP/1.0 404 Not Found");
            echo '404 - Page not found';
            exit();
        }

        return $this->show((int) $sceneId['scene_id']);
    }
}
