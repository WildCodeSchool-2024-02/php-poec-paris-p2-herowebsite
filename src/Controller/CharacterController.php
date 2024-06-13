<?php

namespace App\Controller;

use App\Model\CharacterManager;

class CharacterController extends AbstractController
{
    private $characterManager;

    public const TARGET_DIR = 'assets/images/sprites/';
    public const EXTENSIONS_ALLOWED = ['jpg', 'jpeg', 'png', 'webp'];
    public const MAX_UPLOAD_SIZE = 5000000;

    public const MAX_CHARACTER_NAME_LENGTH = 35;

    public function __construct()
    {
        parent::__construct();
        $this->characterManager = new CharacterManager();
    }

    public function add(): ?string
    {
        $character = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $character = array_map('htmlentities', array_map('trim', $_POST));
            $errors = [];

            if (empty($character["character_name"])) {
                $errors[] = "Le nom du personnage est requis.";
            }

            if (!empty($_FILES['sprite']['full_path'])) {
                $uploadErrors = $this->handleSpriteUpload();
                $errors = array_merge($errors, $uploadErrors);
                if (empty($uploadErrors)) {
                    $character['sprite'] = basename($_FILES['sprite']['name']);
                }
            } else {
                $character['sprite'] = "";
            }

            $validationErrors = $this->validateCharacter($character, $character['story_id']);
            $errors = array_merge($errors, $validationErrors);

            if (empty($errors)) {
                $this->characterManager->insert($character);
            } else {
                error_log('Erreurs lors de l\'ajout du personnage : ' . implode(', ', $errors));
            }
        }

        header('Location:/story/engine/scene/show?story_id=' . $character['story_id'] . '&id='
        . $character['scene_id']);
        return null;
    }

    public function delete(string $storyId, string $sceneId, int $id): ?string
    {
        $this->characterManager->delete((int) $id);

        header('Location:/story/engine/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }

    public function update(): ?string
    {
        $character = [];
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $character = array_map('htmlentities', array_map('trim', $_POST));
            $previousSettings = $this->characterManager->selectOneById($character['character_id']);

            if (empty($character["character_name"])) {
                $errors[] = "Le nom du personnage est requis.";
            }

            if (!empty($_FILES['sprite']['full_path'])) {
                $uploadErrors = $this->handleSpriteUpload();
                $errors = array_merge($errors, $uploadErrors);
                if (empty($uploadErrors)) {
                    $character['sprite'] = basename($_FILES['sprite']['name']);
                } else {
                    $character['sprite'] = $previousSettings['sprite'];
                }
            } elseif ($character['delete_sprite'] === 'true') {
                $this->deleteSpriteFile($previousSettings['sprite']);
                $character['sprite'] = "";
            } else {
                $character['sprite'] = $previousSettings['sprite'];
            }

            if (empty($character['character_name'])) {
                $character['character_name'] = $previousSettings['name'];
            }

            $validationErrors = $this->validateCharacter($character, $character['story_id']);
            $errors = array_merge($errors, $validationErrors);

            if (empty($errors)) {
                $this->characterManager->update($character);
            } else {
                error_log('Erreurs lors de l\'édition du personnage : ' . implode(', ', $errors));
            }
        }

        header('Location:/story/engine/scene/show?story_id=' . $character['story_id'] . '&id='
        . $character['scene_id']);
        return null;
    }

    public function show($storyId)
    {
        $characters = $this->characterManager->selectAll($storyId);
        header('Location: /showchars?story_id=' . $storyId);
        return $this->twig->render(
            'StoryCreation/showCharacters.html.twig',
            [
                'characters' => $characters
            ]
        );
    }

    public function validateCharacter(array $character, string $storyId): array
    {
        $errors = [];
        $characterName = html_entity_decode($character["character_name"]);

        $length = mb_strlen($characterName, 'UTF-8');
        if ($length > self::MAX_CHARACTER_NAME_LENGTH) {
            $errors[] = "Le nom du personnage est trop long, maximum : "
            . self::MAX_CHARACTER_NAME_LENGTH . " caractères.";
        }

        $normalizedCharName = $this->normalizeName($characterName);

        $charactersInStory = $this->characterManager->selectAll($storyId);
        foreach ($charactersInStory as $existingCharacter) {
            if (isset($character['character_id']) && $existingCharacter['id'] == $character['character_id']) {
                continue;
            }

            $normalizedExistName = $this->normalizeName($existingCharacter['name']);
            if ($normalizedExistName === $normalizedCharName) {
                $errors[] = "Ce nom de personnage est déjà utilisé dans cette histoire.";
                break;
            }
        }

        return $errors;
    }
    public function handleSpriteUpload(): array
    {
        $errors = [];
        $targetFile = self::TARGET_DIR . basename($_FILES['sprite']['name']);
        $typeFile = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $dimensionsImage = getimagesize($_FILES['sprite']['tmp_name']);


        if (!$dimensionsImage) {
            $errors[] = 'Votre sprite n\'est pas une image';
        }

        if ($_FILES['sprite']['size'] > self::MAX_UPLOAD_SIZE) {
            $errors[] = 'Votre sprite ne peut pas dépasser 5Mo';
        }

        if (!in_array($typeFile, self::EXTENSIONS_ALLOWED)) {
            $errors[] = 'Votre sprite n\'as pas le bon format ('
                . implode(', ', self::EXTENSIONS_ALLOWED) . ')';
        }

        if (!move_uploaded_file($_FILES['sprite']['tmp_name'], $targetFile)) {
            $errors[] = 'Erreur lors du déplacement du fichier de sprite';
            error_log('Erreur lors du déplacement du fichier de sprite: ' . $_FILES['edit_sprite']['error']);
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

    private function deleteSpriteFile(string $fileName): void
    {
        $filePath = self::TARGET_DIR . $fileName;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
