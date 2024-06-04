<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Model\SceneManager;
use App\Model\CharacterManager;
use App\Model\DialogueManager;
use App\Model\StoryManager;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    protected SceneManager $sceneManager;
    protected DialogueManager $dialogueManager;
    protected CharacterManager $characterManager;
    protected StoryManager $storyManager;

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
        $this->characterManager = new CharacterManager();
        $this->dialogueManager = new DialogueManager();
        $this->storyManager = new StoryManager();
    }
}
