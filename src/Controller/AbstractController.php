<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Model\SceneManager;
use App\Model\CharacterManager;
use App\Model\DialogueManager;
use App\Model\StoryManager;
use App\Model\ChoiceManager;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    public const EXTENSIONS_ALLOWED = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
    public const MAX_UPLOAD_SIZE = 5000000;


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
    }
}
