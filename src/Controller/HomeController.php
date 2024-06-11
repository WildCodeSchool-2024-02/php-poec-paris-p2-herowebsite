<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Affiche la home page
     */
    public function index(): string
    {
        return $this->twig->render('Home/index.html.twig');
    }
}
