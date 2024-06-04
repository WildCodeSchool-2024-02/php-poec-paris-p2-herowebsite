<?php

namespace App\Controller;

use App\Model\StoryManager;
use App\Model\SceneManager;

class StoryController extends AbstractController
{
    /**
     * Affiche la page de sélection d'histoire
     */
    public function index(): string
    {
        $storyManager = new StoryManager();
        $stories = $storyManager->selectAll();

        return $this->twig->render('Story/index.html.twig', ['stories' => $stories]);
    }
}
