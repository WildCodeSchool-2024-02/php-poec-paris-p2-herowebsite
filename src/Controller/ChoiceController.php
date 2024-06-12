<?php

namespace App\Controller;

use App\Model\ChoiceManager;
use App\Model\SceneManager;
use LengthException;

class ChoiceController extends AbstractController
{
    private $choiceManager;
    private $sceneManager;
    public const MAX_CHOICE_LENGTH = 35;

    public function __construct()
    {
        parent::__construct();
        $this->choiceManager = new ChoiceManager();
        $this->sceneManager = new SceneManager();
    }
    public function add()
    {
        $choice = [];
        $errors = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $choice = array_map('htmlentities', array_map('trim', $_POST));
            $scenes = $this->sceneManager->selectAll($choice["story_id"]);
            $existingChoices = $this->choiceManager->selectAll($choice["scene_id"]);

            $validationErrors = $this->validateChoice($choice["choice_body"]);
            $errors = array_merge($errors, $validationErrors);

            if (!in_array($choice["next_scene"], $scenes) && !empty($choice["next_scene"])) {
                $errors[] = "La scene selectionée n'existe pas";
            }

            if (count($existingChoices) >= 3) {
                $errors[] = "Maxmimum de choix déjà atteint pour cette scène";
            }

            if (empty($errors)) {
                $this->choiceManager->insert($choice);
            } else {
                error_log('Erreurs lors de l\'ajout du choix : ' . implode(', ', $errors));
            }

            header('Location:/story/engine/scene/show?story_id=' . $choice['story_id'] . '&id=' . $choice['scene_id']);
            return null;
        }
    }

    public function delete(string $storyId, string $sceneId, int $id)
    {
        $this->choiceManager->delete((int) $id);

        header('Location:/story/engine/scene/show?story_id=' . $storyId . '&id=' . $sceneId);
        return null;
    }

    public function update(): ?string
    {
        $choice = [];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $choice = array_map('htmlentities', array_map('trim', $_POST));
            $previousSettings = $this->choiceManager->selectOneById($choice['id']);
            $choices = $this->sceneManager->selectAll($choice["story_id"]);
            $sceneIds = array_column($choices, 'id');
            $sceneIds[] = 0;

            $validationErrors = $this->validateChoice($choice["choice_body"]);
            $errors = array_merge($errors, $validationErrors);

            if (empty($choice['choice_body'])) {
                $choice['choice_body'] = $previousSettings['body'];
            }

            if (!in_array($choice["next_scene"], $sceneIds) && !empty($choice["next_scene"])) {
                $errors[] = "La scene selectionée n'existe pas";
            }

            if (empty($errors)) {
                $this->choiceManager->update($choice['id'], $choice);
            } else {
                error_log('Erreurs lors de l\'edition du choix : ' . implode(', ', $errors));
            }
        }

        header('Location:/story/engine/scene/show?story_id=' . $choice['story_id'] . '&id=' . $choice['scene_id']);
        return null;
    }

    private function validateChoice(string $choiceBody): array
    {
        $errors = [];

        $choiceBody = html_entity_decode($choiceBody);

        $length = mb_strlen($choiceBody, 'UTF-8');
        if ($length > self::MAX_CHOICE_LENGTH) {
            $errors[] = "Le choix est trop long, maximum : " . self::MAX_CHOICE_LENGTH . " caractères.";
        }

        return $errors;
    }
}
