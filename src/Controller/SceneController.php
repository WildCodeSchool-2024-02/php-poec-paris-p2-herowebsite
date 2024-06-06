<?php

namespace App\Controller;

// use App\Model\UserSaveManager; à venir

class SceneController extends AbstractController
{
    public function add(int $storyId): ?string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $scene = array_map('htmlentities', array_map('trim', $_POST));
            $scene['story_id'] = $storyId;

            $targetDir = 'assets/images/backgrounds/';
            $targetFile = $targetDir . basename($_FILES['background']['name']);
            $typeFile = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $dimensionsImage = getimagesize($_FILES['background']['tmp_name']);

            if (!$dimensionsImage) {
                $errors[] = 'Votre background n\'est pas une image';
            }

            if ($_FILES['background']['size'] > parent::MAX_UPLOAD_SIZE) {
                $errors[] = 'Votre background ne peut pas dépasser 5Mo';
            }

            if (!in_array($typeFile, parent::EXTENSIONS_ALLOWED)) {
                $errors[] = 'Votre background n\'as pas le bon format ('
                    . implode(', ', parent::EXTENSIONS_ALLOWED) . ')';
            }

            if (!move_uploaded_file($_FILES['background']['tmp_name'], $targetFile)) {
                $errors[] = 'Erreur lors du déplacement du fichier de background';
                // Log des informations d'erreur
                error_log('Erreur lors du déplacement du fichier de background: ' . $_FILES['background']['error']);
            }

            if (empty($errors)) {
                $scene['background'] = basename($_FILES['background']['name']);
                $id = $this->sceneManager->insert($scene);
            } else {
                // Log des erreurs dans un fichier de journal
                error_log('Erreurs lors de l\'ajout de la scène: ' . implode(', ', $errors));
                // Insère la scène sans background en cas d'erreur
                $id = $this->sceneManager->insert($scene);
            }

            header('Location:/storycreation/scene/show?' . http_build_query(['story_id' => $storyId, 'id' => $id]));
            return null;
        }

        return $this->twig->render('SceneCreation/add.html.twig');
    }


    public function showCreation(string $storyId, string $id): string
    {
        $scene = $this->sceneManager->selectOneById((int) $id);
        $story = $this->sceneManager->getStory($storyId);
        $dialogues = $this->dialogueManager->getDialogues($id);
        $choices = $this->choiceManager->getChoicesBySceneId((int) $id);
        $characters = $this->characterManager->getCharacters($storyId);
        $allscenes = $this->sceneManager->selectAllByStoryId($storyId);

        return $this->twig->render(
            'SceneCreation/show.html.twig',
            [
                'scene' => $scene,
                'story' => $story,
                'dialogues' => $dialogues,
                'choices' => $choices,
                'characters' => $characters,
                'allscenes' => $allscenes
            ]
        );
    }

    public function delete(string $storyId, string $sceneId): ?string
    {
        $this->sceneManager->delete((int) $sceneId);

        header('Location:/storycreation/show?id=' . $storyId);
        return null;
    }

    // Affiche une scène par son ID et celui de l'histoire
    public function show(int $storyId, int $sceneId): string
    {
        // Utiliser SceneManager pour obtenir les informations sur la scène
        $scene = $this->sceneManager->findScene($storyId, $sceneId);

        // Vérifier si la scène existe, sinon renvoyer une erreur 404
        if (!$scene) {
            header("HTTP/1.0 404 Not Found");
            echo '404 - Page not found';
            exit();
        }

        // Utiliser DialogueManager pour obtenir les dialogues de la scène
        $dialogues = $this->dialogueManager->getDialoguesBySceneId($sceneId);

        // Utiliser ChoiceManager pour obtenir les choix de la scène
        $choices = $this->choiceManager->getChoicesBySceneId($sceneId);

        // Rendre la vue avec les données récupérées
        return $this->twig->render('Scene/show.html.twig', [
            'scene' => $scene,
            'dialogues' => $dialogues,
            'choices' => $choices
        ]);
    }

    // Affiche la première scène d'une histoire en trouvant le scène ID correspondant
    /**
     * Solution alternative, intégrer cette gestion dans le cas où sceneID est null dans la méthode show ⏫
     * Solution 2 rendre le paramètre storyID optionnel et dans ce cas changer le datamapper pour
     * faire une condition qui changerait la requête en ajoutant ORDER BY id ASC LIMIT 1
     */

    public function showFirstScene(int $storyId): string
    {
        $firstSceneId = $this->sceneManager->findFirstSceneIdOfStory($storyId);
        $firstSceneId = intval($firstSceneId);

        // Vérifiez si l'identifiant de la première scène a été trouvé
        if (!$firstSceneId) {
            header("HTTP/1.0 404 Not Found");
            echo '404 - Page not found';
            exit();
        }

        // Afficher la première scène de l'histoire
        return $this->show($storyId, $firstSceneId);
    }
}
