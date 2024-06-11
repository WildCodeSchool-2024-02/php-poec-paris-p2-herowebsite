<?php

namespace App\Controller;

use App\Model\ChoiceManager;
use App\Model\SceneManager;

class ChoiceController extends AbstractController
{
    private $choiceManager;
    private $sceneManager;
    public const MAX_CHOICE_LENGTH = 30;

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

            if (strlen($choice["choice_body"]) >= self::MAX_CHOICE_LENGTH) {
                $errors[] = "Le choix est trop long, maximum : " . self::MAX_CHOICE_LENGTH . " caractères";
            }

            if (!in_array($choice["next_scene"], $scenes) && !empty($choice["next_scene"])) {
                $errors[] = "La scene selectionée n'existe pas";
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

            if (strlen($choice["choice_body"]) >= self::MAX_CHOICE_LENGTH) {
                $errors[] = "Le choix est trop long, maximum : " . self::MAX_CHOICE_LENGTH . " caractères";
            }

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
}
