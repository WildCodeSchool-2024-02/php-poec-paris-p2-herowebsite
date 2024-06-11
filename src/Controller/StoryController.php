<?php

namespace App\Controller;

use App\Model\StoryManager;

class StoryController extends AbstractController
{
    private $storyManager;
    public const MAX_TITLE_LENGTH = 30;

    public function __construct()
    {
        parent::__construct();
        $this->storyManager = new StoryManager();
    }

    /**
     * Affiche la page de sélection d'histoire
     */
    public function index(): string
    {
        $stories = $this->storyManager->selectAll();

        return $this->twig->render('Story/index.html.twig', ['stories' => $stories]);
    }
}
