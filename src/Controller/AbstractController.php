<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Model\StoryManager;
use App\Model\SceneManager;
use App\Model\DialogueManager;
use App\Model\ChoiceManager;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    protected SceneManager $sceneManager;
    protected StoryManager $storyManager;
    protected ChoiceManager $choiceManager;
    protected DialogueManager $dialogueManager;

    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => true,
            ]
        );
        $this->twig->addExtension(new DebugExtension());

        $this->sceneManager = new SceneManager();
        $this->storyManager = new StoryManager();
        $this->choiceManager = new ChoiceManager();
        $this->dialogueManager = new DialogueManager();
    }
}
