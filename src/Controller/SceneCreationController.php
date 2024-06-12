<?php

namespace App\Controller;

use App\Model\SceneManager;
use App\Model\DialogueManager;
use App\Model\ChoiceManager;
use App\Model\CharacterManager;
use App\Model\StoryManager;

class SceneCreationController extends AbstractController
{
    private $sceneManager;
    private $dialogueManager;
    private $choiceManager;
    private $characterManager;
    private $storyManager;
    private const TARGET_DIR = 'assets/images/backgrounds/';
    public const EXTENSIONS_ALLOWED = ['jpg', 'jpeg', 'png', 'webp'];
    public const MAX_UPLOAD_SIZE = 5000000;
    public const MAX_SCENE_TITLE_LENGTH = 35;

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

            if (!empty($_FILES['background']['full_path'])) {
                $uploadErrors = $this->handleBackgroundUpload();
                $errors = array_merge($errors, $uploadErrors);
                if (empty($uploadErrors)) {
                    $scene['background'] = basename($_FILES['background']['name']);
                }
            } else {
                $scene["background"] = "black.jpg";
                $errors[] = "Placeholder chargé";
            }

            $validationErrors = $this->validateScene($scene);
            $errors = array_merge($errors, $validationErrors);

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

    public function update(): ?string
    {
        $scene = [];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $scene = array_map('htmlentities', array_map('trim', $_POST));
            $previousSettings = $this->sceneManager->selectOneById($scene['scene_id']);
            if (!empty($_FILES['background']['full_path'])) {
                $uploadErrors = $this->handleBackgroundUpload();
                $errors = array_merge($errors, $uploadErrors);
                if (empty($uploadErrors)) {
                    $scene['background'] = basename($_FILES['background']['name']);
                } else {
                    $scene['background'] = $previousSettings['background'];
                }
            } else {
                $scene['background'] = $previousSettings['background'];
            }

            if (empty($scene['name'])) {
                $scene['name'] = $previousSettings['name'];
            }

            if ($scene['delete_background'] === 'true') {
                $scene['background'] = "black.jpg";
            }


            $validationErrors = $this->validateScene($scene);
            $errors = array_merge($errors, $validationErrors);


            if (empty($errors)) {
                $this->sceneManager->update($scene);
            } else {
                error_log('Erreur lors de l\'edition de la scene : ' . implode(', ', $errors));
            }

            header('Location:/story/engine/scene/show?story_id='
                . $scene['story_id'] . '&id=' . $scene['scene_id']);
        }
        return null;
    }

    public function show(string $storyId, string $id): string
    {
        $scene = $this->sceneManager->selectOneById((int) $id);
        $story = $this->storyManager->selectOneById((int) $storyId);
        $dialogues = $this->dialogueManager->selectAll((int) $id);
        $choices = $this->choiceManager->selectAll((int) $id);

        $characters = $this->characterManager->selectAll($storyId);
        $allscenes = $this->sceneManager->selectAll($storyId);

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
    public function handleBackgroundUpload(): array
    {
        $errors = [];

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

        return $errors;
    }

    public function validateScene(array $scene): array
    {
        $errors = [];

        $sceneName = html_entity_decode($scene["name"]);

        $length = mb_strlen($sceneName, 'UTF-8');

        if ($length > self::MAX_SCENE_TITLE_LENGTH) {
            $errors[] = "Le titre de votre scène est trop long, maximum : " . self::MAX_SCENE_TITLE_LENGTH
            . " caractères.";
        }

        return $errors;
    }
}
