<?php

namespace App\Controller;

use App\Model\StoryManager;

use App\Model\SceneManager;

class StoryController extends AbstractController
{
    /**
     * Display story selection page
     */
    public function index(): string
    {
        $storyManager = new StoryManager();
        $stories = $storyManager->selectAll();

        return $this->twig->render('Story/index.html.twig', ['stories' => $stories]);
    }
}
