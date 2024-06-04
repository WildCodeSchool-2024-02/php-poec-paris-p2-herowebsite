<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'index',],
    'storycreation' => ['StoryController', 'indexCreation'],
    'storycreation/add' => ['StoryController', 'add',],
    'storycreation/show' => ['StoryController', 'showCreation', ['id']],
    'storycreation/delete' => ['StoryController', 'delete', ['id']],
    'storycreation/scene/add' => ['SceneController', 'add', ['story_id']],
    'storycreation/scene/show' => ['SceneController', 'showCreation', ['story_id', 'id']],
    'storycreation/scene/delete' => ['SceneController', 'delete', ['story_id', 'id']],
    'storycreation/scene/add_dialogue' => ['SceneController', 'addDialogue', ['id']],
    'storycreation/addchar' => ['CharacterController', 'add', ['story_id', 'scene_id']],
    'storycreation/delchar' => ['CharacterController', 'delete', ['story_id', 'scene_id', 'id']]
];
