<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index'], // Affiche la homepage
    'story' => ['StoryController', 'index'], // Affiche la page de sélection d'histoire
    'scene/start' => [
        'SceneController', 'showFirstScene', ['storyId'] // Affiche la première scène de l'histoire
    ],
    'scene/show' => ['SceneController', 'show', ['storyId', 'sceneId']], 
    // Affiche une scène à l'aide de son histoire
    'storycreation' => ['StoryController', 'indexCreation'],
    'storycreation/add' => ['StoryController', 'add',],
    'storycreation/show' => ['StoryController', 'showCreation', ['id']],
    'storycreation/delete' => ['StoryController', 'delete', ['id']],
    'storycreation/scene/add' => ['SceneController', 'add', ['story_id']],
    'storycreation/scene/show' => ['SceneController', 'showCreation', ['story_id', 'id']],
    'storycreation/scene/delete' => ['SceneController', 'delete', ['story_id', 'id']],
    'storycreation/scene/add_dial' => ['DialogueController', 'add', ['story_id', 'scene_id']],
    'storycreation/scene/del_dial' => ['DialogueController', 'delete', ['story_id', 'scene_id', 'id']],
    'storycreation/scene/update_dial' => ['DialogueController', 'update', ['story_id', 'scene_id', 'id']],
    'storycreation/showchars' => ['CharacterController', 'show', ['story_id']],
    'storycreation/addchar' => ['CharacterController', 'add', ['story_id', 'scene_id']],
    'storycreation/delchar' => ['CharacterController', 'delete', ['story_id', 'scene_id', 'id']],
    'storycreation/update_char' => ['CharacterController', 'update', ['story_id', 'scene_id', 'id']],
    'storycreation/addchoice' => ['ChoiceController', 'add', ['story_id', 'scene_id', 'next_scene_id']],
    'storycreation/delchoice' => ['ChoiceController', 'delete', ['story_id', 'scene_id', 'id']],
    'storycreation/update_choice' => ['ChoiceController', 'update', ['story_id', 'scene_id', 'id']]
];
