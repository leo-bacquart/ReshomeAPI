<?php

namespace Hetic\ReshomeApi\Controller;

use http\Exception\RuntimeException;

// Classe abstraite de base pour tous les contrôleurs
abstract class BaseController
{
    // Paramètres provenant de la requête
    protected array $params;

    // Répertoires pour les vues, les templates et les images
    protected string $viewDir;
    protected string $templateDir;
    protected string $imagesDir;


    public function __construct()
    {
        // Initialise les répertoires pour les vues, les templates et les images
        $this->viewDir = dirname(__DIR__, 1) . '/View/';
        $this->templateDir = $this->viewDir . '/Template/';
        $this->imagesDir = dirname(__DIR__, 2) . '/public/images/';
    }

    // Méthode abstraite pour se connecter (doit être implémentée dans les sous-classes)
    protected function getConnection(int $user_id, string $given_password)
    {
    }
}
