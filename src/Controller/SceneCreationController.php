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
    // Initialise le tableau d'erreurs
        $errors = [];

    // Vérifie si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupère et nettoie les données du formulaire
            $scene = array_map('htmlentities', array_map('trim', $_POST));
            $scene['story_id'] = $storyId;

            // Gère l'upload du background
            if (!empty($_FILES['background']['full_path'])) {
                $uploadErrors = $this->handleBackgroundUpload();
                $errors = array_merge($errors, $uploadErrors);
                if (empty($uploadErrors)) {
                    $scene['background'] = basename($_FILES['background']['name']);
                }
            } else {
                // Utilise un placeholder si aucun background n'est uploadé
                $scene["background"] = "black.jpg";
                $errors[] = "Placeholder chargé";
            }

            // Valide la scène
            $validationErrors = $this->validateScene($scene);
            $errors = array_merge($errors, $validationErrors);

            // Vérifie s'il y a des erreurs
            if (empty($errors)) {
                // Aucune erreur, insère la scène
                $scene['background'] = basename($_FILES['background']['name']);
                $id = $this->sceneManager->insert($scene);
                header('Location:/story/engine/scene/show?' . http_build_query(['story_id' => $storyId, 'id' => $id]));
                return null;
            } else {
                // Il y a des erreurs, logge les erreurs
                error_log('Erreurs lors de l\'ajout de la scène: ' . implode(', ', $errors));

                // Si l'erreur n'est pas bloquante (comme l'absence de sprite), insère quand même la scène
                if (!in_array("Ce titre de scène est déjà utilisé dans cette histoire.", $errors)) {
                    $scene['background'] = basename($_FILES['background']['name']);
                    $id = $this->sceneManager->insert($scene);
                    header('Location:/story/engine/scene/show?'
                    . http_build_query(['story_id' => $storyId, 'id' => $id]));
                    return null;
                }

                // Retourne à la vue de création avec les erreurs
                return $this->twig->render('SceneCreation/add.html.twig', ['errors' => $errors]);
            }
        }

    // Si la méthode n'est pas POST, retourne simplement la vue de création de scène
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
            $errors[] = "Le titre de votre scène est trop long, maximum : "
            . self::MAX_SCENE_TITLE_LENGTH . " caractères.";
        }

        $normalizedSceneName = $this->normalizeName($sceneName);

        // Récupérer toutes les scènes de l'histoire
        $existingScenes = $this->sceneManager->selectAllByStory($scene['story_id']);

        foreach ($existingScenes as $existingScene) {
            if (isset($scene['scene_id']) && $existingScene['id'] == $scene['scene_id']) {
                continue;
            }

            $normalizedExistName = $this->normalizeName($existingScene['name']);
            if ($normalizedExistName === $normalizedSceneName) {
                $errors[] = "Ce titre de scène est déjà utilisé dans cette histoire.";
                break;
            }
        }

        return $errors;
    }
    private function normalizeName(string $name): string
    {
        $name = mb_strtolower($name, 'UTF-8');

        $name = strtr(
            $name,
            'àáâäãåçèéêëìíîïñòóôöõùúûüýÿ',
            'aaaaaaceeeeiiiinooooouuuuyy'
        );

        $name = preg_replace('/\s+/', '', $name);

        $name = preg_replace('/[^a-z0-9]/', '', $name);

        return $name;
    }
}
