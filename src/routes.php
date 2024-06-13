<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    // Affichage d'une histoire
    '' => ['HomeController', 'index'],
    'story' => ['StoryController', 'index'],
    'story/scene/start' => ['SceneController', 'showFirstScene', ['story_id']],
    'story/scene/show' => ['SceneController', 'show', ['scene_id']],
    // Création d'une histoire
    'story/engine' => ['StoryCreationController', 'index'],
    'story/engine/add' => ['StoryCreationController', 'add',],
    'story/engine/show' => ['StoryCreationController', 'show', ['id']],
    'story/engine/delete' => ['StoryCreationController', 'delete', ['id']],
    // Création d'une scène
    'story/engine/scene/add' => ['SceneCreationController', 'add', ['story_id']],
    'story/engine/scene/show' => ['SceneCreationController', 'show', ['story_id', 'id']],
    'story/engine/scene/delete' => ['SceneCreationController', 'delete', ['story_id', 'id']],
    'story/engine/scene/update' => ['SceneCreationController', 'update', ['story_id', 'id']],
    // Création d'un personnage
    'story/engine/character/show' => ['CharacterController', 'show', ['story_id']],
    'story/engine/character/add' => ['CharacterController', 'add'],
    'story/engine/character/delete' => ['CharacterController', 'delete', ['story_id', 'scene_id', 'id']],
    'story/engine/character/update' => ['CharacterController', 'update'],
    // Création d'un dialogue
    'story/engine/dialogue/add' => ['DialogueController', 'add'],
    'story/engine/dialogue/delete' => ['DialogueController', 'delete', ['story_id', 'scene_id', 'id']],
    'story/engine/dialogue/update' => ['DialogueController', 'update'],
    // Création d'un choix
    'story/engine/choice/add' => ['ChoiceController', 'add'],
    'story/engine/choice/delete' => ['ChoiceController', 'delete', ['story_id', 'scene_id', 'id']],
    'story/engine/choice/update' => ['ChoiceController', 'update']
];
