<?php

namespace App\Controller;

use App\Model\StoryManager;
use App\Model\SceneManager;

class StoryCreationController extends AbstractController
{
    private $storyManager;
    private $sceneManager;
    public const MAX_TITLE_LENGTH = 35;

    public function __construct()
    {
        parent::__construct();
        $this->storyManager = new StoryManager();
        $this->sceneManager = new SceneManager();
    }

    public function index(): ?string
    {
        $stories = $this->storyManager->selectAll();

        return $this->twig->render('StoryCreation/index.html.twig', ['stories' => $stories]);
    }
    public function show(string $id): string
    {
        $story = $this->storyManager->selectOneById((int) $id);
        $scenes = $this->sceneManager->selectAll((int) $id);

        return $this->twig->render(
            'StoryCreation/show.html.twig',
            [
                'story' => $story,
                'scenes' => $scenes,
            ]
        );
    }
    public function add(): ?string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $story = array_map('htmlentities', array_map('trim', $_POST));

            if (mb_strlen(html_entity_decode($story["name"]), 'UTF-8') >= self::MAX_TITLE_LENGTH) {
                $errors[] = "Le nom de votre histoire est trop long";
            }
            if (empty($errors)) {
                $id = $this->storyManager->insert($story);
                header('Location:/story/engine/show?id=' . $id);
                return null;
            } else {
                error_log('Erreurs lors de l\'ajout de l\'histoire: ' . implode(', ', $errors));
                return null;
            }
        }

        return $this->twig->render('StoryCreation/add.html.twig');
    }
    public function delete(int $id): ?string
    {
        $this->storyManager->delete((int) $id);

        header('Location:/story/engine');
        return null;
    }
}
