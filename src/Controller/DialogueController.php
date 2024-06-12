<?php

namespace App\Controller;

use App\Model\DialogueManager;
use App\Model\CharacterManager;

class DialogueController extends AbstractController
{
    private $dialogueManager;
    private $characterManager;
    public const MAX_DIALOGUE_LENGTH = 150;
    public function __construct()
    {
        parent::__construct();
        $this->dialogueManager = new DialogueManager();
        $this->characterManager = new CharacterManager();
    }
    public function add(): ?string
    {
        $dialogue = [];
        $errors = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dialogue = array_map('htmlentities', array_map('trim', $_POST));

            $validationErrors = $this->validateDialogue($dialogue);
            $errors = array_merge($errors, $validationErrors);

            if (empty($errors)) {
                $this->dialogueManager->insert($dialogue);
            } else {
                error_log('Erreurs lors de l\'ajout de la ligne de dialogue : ' . implode(', ', $errors));
            }
        }
        header('Location:/story/engine/scene/show?story_id='
        . $dialogue['story_id'] . '&id=' . $dialogue['scene_id']);
        return null;
    }

    public function delete(string $storyId, string $sceneId, int $id): ?string
    {
        $this->dialogueManager->delete((int) $id);

        header('Location:/story/engine/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }

    public function update(): ?string
    {
        $dialogue = [];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dialogue = array_map('htmlentities', array_map('trim', $_POST));
            $previousSettings = $this->dialogueManager->selectOneById($dialogue['dialogue_id']);

            if (empty($dialogue["dialogue_body"])) {
                $dialogue['dialogue_body'] = $previousSettings['body'];
            }

            $validationErrors = $this->validateDialogue($dialogue);
            $errors = array_merge($errors, $validationErrors);

            if (empty($errors)) {
                $this->dialogueManager->update($dialogue);
            } else {
                error_log('Erreurs lors de l\'edition de la ligne de dialogue : ' . implode(', ', $errors));
            }
        }
        header('Location:/story/engine/scene/show?story_id=' . $dialogue['story_id'] . '&id=' . $dialogue['scene_id']);
        return null;
    }

    public function validateDialogue(array $dialogue): array
    {
        $errors = [];
        $character = $this->characterManager->selectAll($dialogue["story_id"]);
        $characterIds = array_column($character, 'id');

        $dialogueBody = html_entity_decode($dialogue["dialogue_body"]);

        $length = mb_strlen($dialogueBody, 'UTF-8');
        if ($length > self::MAX_DIALOGUE_LENGTH) {
            $errors[] = "Votre ligne de dialogue est trop longue, maximum : "
             . self::MAX_DIALOGUE_LENGTH . " caractères.";
        }

        if (!in_array($dialogue["character_id"], $characterIds)) {
            $errors[] = "Le personnage sélectionné n'existe pas";
        }

        return $errors;
    }
}
