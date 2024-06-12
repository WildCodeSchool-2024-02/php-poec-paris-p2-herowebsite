<?php

namespace App\Controller;
use App\Model\UserManager;

class UserController extends AbstractController
{
    private UserManager $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    public function login()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $data = array_map('htmlentities', array_map('trim', $_POST));

            $user = $this->userManager->selectOneByPseudo($data['name']);

            if(empty($data['name']))
            {
                $errors[] = "Merci de renseigner votre pseudo.";
            }
            if(strlen($data['name']) > 30)
            {
                $errors[] = "Votre pseudo est trop long.";
            }
            if(empty($user))
            {
                $errors[] = "Ce compte n'existe pas.";
                return $this->twig->render('User/login.html.twig', ['errors' => $errors]); 
            }
            if(empty($data['password']))
            {
                $errors[] = "Merci de renseigner votre mot de passe.";
            }
            if(strlen($data['password']) > 255)
            {
                $errors[] = "Votre mot de passe est trop long.";
            }            
            if(empty($errors))
            {
                if(!password_verify($data['password'], $user['password']))
                {
                    $errors[] = "Le mot de passe ne correspond pas.";
                }
                else
                {
                    header("Location: /");
                    return null;                 
                }
            }
            if(!empty($errors))
                {
                    return $this->twig->render('User/login.html.twig', ['errors' => $errors]); 
                }
        }
        return $this->twig->render('User/login.html.twig');
    }
    
    public function register()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $data = array_map('htmlentities', array_map('trim', $_POST));
            $user = $this->userManager->selectOneByPseudo($data['name']);
            if($user)
            {
                $error = 'Ce compte existe déjà. Si ce compte vous appartient, merci de vous connecter. Sinon, choisissez un autre pseudo.';
                return $this->twig->render('User/login.html.twig', ['error' => $error]); 
            }
            if(empty($data['name']))
            {
                $errors[] = "Merci de renseigner votre pseudo.";
            }
            if(strlen($data['name']) > 30)
            {
                $errors[] = "Votre pseudo est trop long.";
            }
            if(empty($data['password']))
            {
                $errors[] = "Merci de renseigner votre mot de passe.";
            }
            if(strlen($data['password']) > 255)
            {
                $errors[] = "Votre mot de passe est trop long.";
            }            
            if(empty($errors))
            {
                $this->userManager->insert($data);
                header('Location: /user/login');
                return null;
            }
            if(!empty($errors))
                {
                    return $this->twig->render('User/register.html.twig', ['errors' => $errors]); 
                }
        }
        return $this->twig->render('User/register.html.twig');
    }
}
