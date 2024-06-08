<?php

namespace App\Controller;

class ConnexionController extends AbstractController
{


    /**
     * Affiche la page de connexion
     */
    public function index(): string
    {
        return $this->twig->render('Connexion/index.html.twig');
    }

    public function treatDatasFormUser(): array
    {
        //Récupérer les données envoyées en POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = array_map('htmlentities', array_map('trim', $_POST)); //nettoyage des données
            $name = $user['name']; //déclaration variable name
            $password = $user['password']; // déclaration variable password

            $errors = []; // déclaration tableau d'erreurs
            if (empty($name)) {
                $errors[] = 'Merci de renseigner votre nom !';
            } elseif (empty($password)) {
                $errors[] = 'Merci de renseigner votre mot de passe !';
            }
        }

        if (count($errors) > 0) {
            header("Location: 'errorConnexion'");
            return $this->twig->render('')
            die;
        } else {
            $userForm = [
                'name' => $name,
                'password' => $password
            ];
        }
        return $userForm;
    }   
}
