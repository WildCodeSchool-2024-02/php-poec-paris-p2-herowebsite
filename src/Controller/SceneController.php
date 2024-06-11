<?php

namespace App\Controller;

use App\Model\SceneManager;
use App\Model\DialogueManager;
use App\Model\ChoiceManager;
use App\Model\CharacterManager;
use App\Model\StoryManager;

// use App\Model\UserSaveManager; à venir

class SceneController extends AbstractController
{
    private $sceneManager;
    private $dialogueManager;

    private $choiceManager;

    private $characterManager;

    private $storyManager;

    private const TARGET_DIR = 'assets/images/backgrounds/';

    public const EXTENSIONS_ALLOWED = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    public const MAX_UPLOAD_SIZE = 5000000;

    public const MAX_SCENE_TITLE_LENGTH = 30;

    public function __construct()
    {
        parent::__construct();
        $this->sceneManager = new SceneManager();
        $this->dialogueManager = new DialogueManager();
        $this->choiceManager = new ChoiceManager();
        $this->characterManager = new CharacterManager();
        $this->storyManager = new StoryManager();
    }
    public function add(int $storyId): ?string
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $scene = array_map('htmlentities', array_map('trim', $_POST));
            $scene['story_id'] = $storyId;

            if (!empty($_FILES['full_path'])) {
                $targetFile = self::TARGET_DIR . basename($_FILES['background']['name']);
                $typeFile = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $dimensionsImage = getimagesize($_FILES['background']['tmp_name']);


                if (!$dimensionsImage) {
                    $errors[] = 'Votre background n\'est pas une image';
                }

                if ($_FILES['background']['size'] > self::MAX_UPLOAD_SIZE) {
                    $errors[] = 'Votre background ne peut pas dépasser ' . self::MAX_UPLOAD_SIZE / 1000000 . 'Mo';
                }

                if (!in_array($typeFile, self::EXTENSIONS_ALLOWED)) {
                    $errors[] = 'Votre background n\'as pas le bon format ('
                        . implode(', ', self::EXTENSIONS_ALLOWED) . ')';
                }

                if (!move_uploaded_file($_FILES['background']['tmp_name'], $targetFile)) {
                    $errors[] = 'Erreur lors du déplacement du fichier de background';
                    error_log('Erreur lors du déplacement du fichier de background: ' . $_FILES['background']['error']);
                }
            } else {
                $scene["background"] = "";
            }

            if (strlen($scene["name"]) >= self::MAX_SCENE_TITLE_LENGTH) {
                $errors[] = "Le titre de votre scene est trop long, maximum : "
                 . self::MAX_SCENE_TITLE_LENGTH . " caractères.";
            }

            if (empty($errors)) {
                $scene['background'] = basename($_FILES['background']['name']);
                $id = $this->sceneManager->insert($scene);
            } else {
                error_log('Erreurs lors de l\'ajout de la scène: ' . implode(', ', $errors));
                // Insère la scène sans background en cas d'erreur
                $id = $this->sceneManager->insert($scene);
            }

            header('Location:/story/engine/scene/show?' . http_build_query(['story_id' => $storyId, 'id' => $id]));
            return null;
        }

        return $this->twig->render('SceneCreation/add.html.twig');
    }


    public function showCreation(string $storyId, string $id): string
    {
        $scene = $this->sceneManager->selectOneById((int) $id);
        $story = $this->storyManager->selectOneById((int) $storyId);
        $dialogues = $this->dialogueManager->selectAllByScene((int) $id);
        $choices = $this->choiceManager->selectAllByScene((int) $id);
        $characters = $this->characterManager->selectByStory($storyId);
        $allscenes = $this->sceneManager->selectAllByStory($storyId);

        return $this->twig->render(
            'SceneCreation/show.html.twig',
            [
                'scene' => $scene,
                'story' => $story,
                'dialogues' => $dialogues,
                'choices' => $choices,
                'characters' => $characters,
                'allscenes' => $allscenes,
            ]
        );
    }

    public function delete(string $storyId, string $sceneId): ?string
    {
        $this->sceneManager->delete((int) $sceneId);

        header('Location:/story/engine/show?id=' . $storyId);
        return null;
    }

    public function show(int $sceneId): string
    {
        $scene = $this->sceneManager->selectOneById($sceneId);

        if (!$scene) {
            header("HTTP/1.0 404 Not Found");
            echo '404 - Page not found';
            exit();
        }

        $dialogues = $this->dialogueManager->selectAllByScene($sceneId);

        $choices = $this->choiceManager->selectAllByScene($sceneId);

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
