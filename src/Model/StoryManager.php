<?php

namespace App\Model;

use PDO;

class StoryManager extends AbstractManager
{
    public const TABLE = 'story';

    // Hérite de la méthode SelectAll pour récupérer toutes les histoires après défintion de la table
}
